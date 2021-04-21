<?php



namespace App\Models\Common;



use App\Models\Database;

class SequenceModel
{
    public function getEmployeeSequence(){
        $employeePrefix = k1_employee_user_prefix;
        $employee = $this->getEmployeeLastSequence();
        $employeeSequence = $this->getSequenceRules($employeePrefix);
        $increment = $employeeSequence->increment;
        $sequence = $employeeSequence->sequence;
        $lastSequence = $employee->employee_id;
        $id = explode("_",$lastSequence);
        $newId = sprintf("%05d", $id[1]+$increment);

        $newSequence = $employeePrefix."_".$newId;

        return $newSequence;
    }

    public function getContractorSequence(){
        $contractorPrefix = contractor_user_prefix;
        $contractor = $this->getContractorLastSequence();
        $contractorSequence = $this->getSequenceRules($contractorPrefix);
        $increment = $contractorSequence->increment;
        $sequence = $contractorSequence->sequence;
        $lastSequence = $contractor->contractor_id;
        $id = explode("_",$lastSequence);
        $newId = sprintf("%05d", $id[1]+$increment);

        $newSequence = $contractorPrefix."_".$newId;
        return $newSequence;
    }

    public function getCompanySequence(){
        $prefix = date("Ymd");
        $increment = 1;
        $company = $this->getCompanyLastSequence();
        $lastSequence = $company->company_id;
        $id = substr($lastSequence, -4);
        $newId = sprintf("%04d", $id+$increment);
        $newSequence = $prefix.$newId;

        return $newSequence;
    }

    public function getGroupSequence(){
        $prefix = date("Ymd");
        $increment = 1;
        $group = $this->getGroupLastSequence();
        $lastSequence = $group->group_id;
        $id = substr($lastSequence, -4);
        $newId = sprintf("%04d", $id+$increment);
        $newSequence = $prefix.$newId;

        return $newSequence;
    }

    public function getSequenceRules($prefix){
        $queryString = "SELECT prefix, sequence, increment FROM mng_sequence WHERE prefix = ?";
        $parameter = array($prefix);

        $data = (new Database())->readQueryExecution($queryString, $parameter);
        return $data[0];
    }

    public function getContractorLastSequence(){
        $queryString = "SELECT contractor_id, insert_date FROM mst_contractor ORDER BY insert_date DESC LIMIT ?";
        $parameter = array(1);

        $data = (new Database())->readQueryExecution($queryString, $parameter);
        return $data[0];
    }

    public function getEmployeeLastSequence(){
        $queryString = "SELECT employee_id, insert_date FROM mst_employee ORDER BY insert_date DESC  LIMIT ?";
        $parameter = array(1);

        $data = (new Database())->readQueryExecution($queryString, $parameter);
        return $data[0];
    }

    public function getCompanyLastSequence(){
        $queryString = "SELECT company_id, insert_date FROM mst_company ORDER BY insert_date DESC LIMIT ?";
        $parameter = array(1);

        $data = (new Database())->readQueryExecution($queryString, $parameter);
        return $data[0];
    }

    public function getGroupLastSequence(){
        $queryString = "SELECT group_id, insert_date FROM mst_group ORDER BY insert_date DESC LIMIT ?";
        $parameter = array(1);

        $data = (new Database())->readQueryExecution($queryString, $parameter);
        return $data[0];
    }
}