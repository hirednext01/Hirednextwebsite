<?php

namespace App\Controllers\Api;

use App\Models\CompaniesModel;

class CompaniesApi extends BaseApiController
{
    protected $companiesModel;

    public function __construct()
    {
        parent::__construct();
        $this->companiesModel = new CompaniesModel();
    }

    public function index()
    {
        try {
            $companies = $this->companiesModel->getActiveCompanies();
            return $this->successResponse($companies, 'Companies retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve companies: ' . $e->getMessage(), 500);
        }
    }

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Company ID is required', 400);
            }

            $company = $this->companiesModel->find($id);
            if (!$company) {
                return $this->errorResponse('Company not found', 404);
            }

            return $this->successResponse($company, 'Company retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve company: ' . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        try {
            $rules = [
                'name' => 'required|min_length[3]',
                'industry' => 'required',
                'logo' => 'permit_empty'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);
            $data['status'] = $data['status'] ?? 'active';
            $data['sort_order'] = $data['sort_order'] ?? 1;
            
            $companyId = $this->companiesModel->insert($data);
            $company = $this->companiesModel->find($companyId);
            
            return $this->successResponse($company, 'Company created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create company: ' . $e->getMessage(), 500);
        }
    }

    public function update($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Company ID is required', 400);
            }

            $rules = [
                'name' => 'required|min_length[3]',
                'industry' => 'required',
                'logo' => 'permit_empty'
            ];

            $validation = $this->validateRequest($rules);
            if ($validation !== true) {
                return $validation;
            }

            $data = $this->request->getJSON(true);
            $data['updated_at'] = date('Y-m-d H:i:s');
            
            $this->companiesModel->update($id, $data);
            $company = $this->companiesModel->find($id);
            
            return $this->successResponse($company, 'Company updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update company: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id = null)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Company ID is required', 400);
            }

            $company = $this->companiesModel->find($id);
            if (!$company) {
                return $this->errorResponse('Company not found', 404);
            }

            $this->companiesModel->delete($id);
            
            return $this->successResponse(null, 'Company deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete company: ' . $e->getMessage(), 500);
        }
    }
}
