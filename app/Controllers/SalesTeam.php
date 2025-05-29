<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SalesTeamModel;

class SalesTeam extends BaseController
{
    protected $teamModel;

    public function __construct()
    {
        $this->teamModel = new SalesTeamModel();
    }

    public function index()
    {
        $data['teams'] = $this->teamModel->findAll();
        return view('sales_team/index', $data);
    }

    public function create()
    {
        return view('sales_team/create');
    }

    public function store()
    {
        $this->teamModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/sales_team');
    }

    public function edit($id)
    {
        $data['team'] = $this->teamModel->find($id);
        return view('sales_team/edit', $data);
    }

    public function update($id)
    {
        $this->teamModel->update($id, [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/sales_team');
    }

    public function delete($id)
    {
        $this->teamModel->delete($id);
        return redirect()->to('/sales_team');
    }
}