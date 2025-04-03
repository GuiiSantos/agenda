<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class WebController extends BaseController
{
    public function index()
    {
        if (!session()->get('loggedIn')) {
            return redirect()->to('/login');
        }

        return view('Web/activities');
    }

    public function createActivities()
    {
        $session = session();

        if (!$this->validate([
            'name' => 'required|min_length[3]',
            'description' => 'required|min_length[5]',
            'start_datetime' => 'required|valid_date',
            'end_datetime' => 'required|valid_date',
            'status' => 'required|in_list[pending,completed,cancelled]',
        ])) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'user_id' => $this->request->getPost('user_id'),
        ];

        $startDatetime = $this->request->getPost('start_datetime');
        $endDatetime = $this->request->getPost('end_datetime');

        try {
            $startTime = new \DateTime($startDatetime);
            $endTime = new \DateTime($endDatetime);

            $data['start_time'] = $startTime->format('Y-m-d H:i:s');
            $data['end_time'] = $endTime->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao formatar as datas.'
            ]);
        }

        $activityModel = new ActivityModel();

        try {
            $saved = $activityModel->save($data);

            if (!$saved) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Erro ao tentar salvar a atividade. Tente novamente mais tarde.'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Atividade criada com sucesso!'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro inesperado ao salvar atividade: ' . $e->getMessage()
            ]);
        }
    }

    public function getActivities()
    {

        $idUser = session()->get("user")["id"];
        try {
            $activityModel = new ActivityModel();
            $page = $this->request->getVar('page') ?: 1;

            $activities = $activityModel->where('user_id', $idUser)->orderBy('start_time', 'ASC')->paginate(12, 'default', $page);

            $pager = $activityModel->pager;

            return $this->response->setJSON([
                'activities' => $activities,
                'pager' => [
                    'total' => $pager->getTotal(),
                    'perPage' => $pager->getPerPage(),
                    'currentPage' => $pager->getCurrentPage(),
                    'totalPages' => $pager->getPageCount()
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->response->setJSON(['error' => 'Error while fetching activities.']);
        }
    }


    public function calendar()
    {
        if (!session()->get('loggedIn')) {
            return redirect()->to('/login');
        }

        return view('Web/calendar');
    }


    public function login()
    {
        $session = session();
        if ($session->get('loggedIn')) {
            return redirect()->to('/activities');
        }

        return view('Web/login');
    }

    public function authenticate()
    {
        $session = session();

        $validationRules = [
            'login' => 'required|min_length[3]',
            'senha' => 'required|min_length[6]'
        ];

        $validationMessages = [
            'login' => [
                'required' => 'O campo "Usuário" é obrigatório.',
                'min_length' => 'O "Usuário" deve ter no mínimo 3 caracteres.'
            ],
            'senha' => [
                'required' => 'O campo "Senha" é obrigatório.',
                'min_length' => 'A "Senha" deve ter no mínimo 6 caracteres.'
            ]
        ];

        if (!$this->validate($validationRules, $validationMessages)) {
            return redirect()->to('/login')->withInput()->with('validation', $this->validator);
        }

        $login = $this->request->getPost('login');
        $senha = $this->request->getPost('senha');

        $userModel = new UserModel();

        $user = $userModel->where('login', $login)->first();

        if ($user && password_verify($senha, $user['password'])) {
            $session->set('loggedIn', true);
            $session->set('user', $user);

            return redirect()->to('/activities');
        } else {
            $session->setFlashdata('erro', 'Usuário ou senha inválidos.');
            return redirect()->to('/login');
        }
    }


    public function register()
    {
        return view('Web/register', ['validation' => \Config\Services::validation()]);
    }

    public function createAccount()
    {

        $validationRules = [
            'login' => [
                'rules' => 'required|min_length[3]|is_unique[users.login]',
                'errors' => [
                    'required' => 'O campo login é obrigatório.',
                    'min_length' => 'O login deve ter pelo menos 3 caracteres.',
                    'is_unique' => 'Esse login já está em uso.'
                ]
            ],
            'senha' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'O campo senha é obrigatório.',
                    'min_length' => 'A senha deve ter pelo menos 6 caracteres.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return view('Web/register', [
                'validation' => $this->validator
            ]);
        }

        $userModel = new UserModel();

        $login = $this->request->getPost('login');
        $senha = $this->request->getPost('senha');


        $userModel->save([
            'login' => $login,
            'password' => password_hash($senha, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function updateActivities()
    {
        $session = session();

        if (!$this->validate([
            'name' => 'required|min_length[3]|max_length[255]',
            'description' => 'required',
            'start_time' => 'required|valid_date',
            'end_time' => 'required|valid_date',
            'status' => 'required|in_list[pending,completed,cancelled]'
        ])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Falha na validação dos dados.',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'status' => $this->request->getPost('status'),
        ];

        $activityModel = new ActivityModel();

        $id = $this->request->getPost('id');
        $update = $activityModel->update($id, $data);

        if ($update) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Atividade atualizada com sucesso!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erro ao atualizar a atividade.'
            ]);
        }
    }

    public function deleteActivity($id)
    {
        $activityModel = new ActivityModel();

        if ($activityModel->delete($id)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function getCalendarActivities()
    {
        $activityModel = new ActivityModel();

        $idUser = session()->get("user")["id"];
        $activities = $activityModel->where('user_id', $idUser)->findAll();

        if (empty($activities)) {
            return $this->response->setJSON([]);
        }

        $events = [];

        foreach ($activities as $activity) {
            $events[] = [
                'title' => $activity['name'],
                'start' => $activity['start_time'],
                'end' => $activity['end_time'],
                'className' => $this->getStatusClass($activity['status'])
            ];
        }

        return $this->response->setJSON($events);
    }

    private function getStatusClass($status)
    {
        switch ($status) {
            case 'completed':
                return 'status-concluida';
            case 'pending':
                return 'status-pendente';
            case 'cancelled':
                return 'status-cancelada';
            default:
                return 'status-cancelled';
        }
    }

    public function logout()
    {

        $session = session();

        $session->destroy();

        return redirect()->to('/login')->with('success', 'Você foi deslogado com sucesso!');
    }

}
