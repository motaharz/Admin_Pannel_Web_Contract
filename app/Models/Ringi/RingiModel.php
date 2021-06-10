<?php


namespace App\Models\Ringi;


use App\Models\Database;

class RingiModel
{
    public function getAllRingi(){
        $data = $this->getAllData();
        return $this->mapData($data);
    }

    public function getAllData(){
        $queryString = "SELECT ringi_no, applicant_name, ringi_type, target_area, target_name, discount_service_type, ringi_detail, summary_condition,
                        before_summary_price, after_summary_price, summary_period, DATE_FORMAT(start_date, '%Y/%m/%d') AS start_date, DATE_FORMAT(end_date, '%Y/%m/%d')
                        AS end_date, purpose, memo, delete_flag FROM trn_ringi_info WHERE delete_flag = ?";
        $queryParameter = array(1);

        return (new Database())->readQueryExecution($queryString, $queryParameter);
    }

    public function mapData($datas = array()){
        if(isset($datas) && is_array($datas)){
            $length = count($datas);
            $mappedData = array();

            for($i = 0; $i < $length; $i++){
                $data = $datas[$i];
                $ringi = new Ringi();
                if(isset($data)){
                    $ringi->setNo($data->ringi_no  ?? NULL);
                    $ringi->setApplicantName($data->applicant_name ?? NULL);
                    $ringi->setType($data->ringi_type ?? NULL);
                    $ringi->setTargetArea($data->target_area ?? NULL);
                    $ringi->setTargetName($data->target_name ?? NULL);
                    $ringi->setDiscountServiceType($data->discount_service_type ?? NULL);
                    $ringi->setDetail($data->ringi_detail ?? NULL);
                    $ringi->setSummaryCondition($data->summary_condition ?? NULL);
                    $ringi->setBeforeSummaryPrice($data->before_summary_price ?? NULL);
                    $ringi->setAfterSummaryPrice($data->after_summary_price ?? NULL);
                    $ringi->setSummaryPeriod($data->summary_period ?? NULL);
                    $ringi->setStartDate($data->start_date ?? NULL);
                    $ringi->setEndDate($data->end_date ?? NULL);
                    $ringi->setPurpose($data->purpose ?? NULL);
                    $ringi->setMemo($data->memo ?? NULL);
                    $ringi->setDeleteFlag($data->delete_flag ?? NULL);
                }
                array_push($mappedData, $ringi);
            }
            return $mappedData;
        }
        else{
            return $datas;
        }
    }

    public function getRingiByNo($ringiNo){
        $data = $this->getRingiDataByNo($ringiNo);
        return $this->mapData($data);
    }

    public function getRingiDataByNo($ringiNo){
        $queryString = "SELECT ringi_no, applicant_name, ringi_type, target_area, target_name, discount_service_type, ringi_detail, summary_condition,
                        before_summary_price, after_summary_price, summary_period, DATE_FORMAT(start_date, '%Y/%m/%d') AS start_date, DATE_FORMAT(end_date, '%Y/%m/%d')
                        AS end_date, purpose, memo, delete_flag FROM trn_ringi_info WHERE ringi_no = ? AND delete_flag = ?";
        $queryParameter = array($ringiNo, 1);

        return (new Database())->readQueryExecution($queryString, $queryParameter);
    }

    public function getRingiByContractId($contractId){
        $data = $this->getRingiDataByContractId($contractId);
        return $this->mapData($data);
    }

    public function getRingiDataByContractId($contractId){
        $queryString = "SELECT contract_id, ri.ringi_no, applicant_name, ringi_type, target_area, target_name, discount_service_type, ringi_detail, summary_condition,
                        before_summary_price, after_summary_price, summary_period, DATE_FORMAT(start_date, '%Y/%m/%d') AS start_date, DATE_FORMAT(end_date, '%Y/%m/%d')
                        AS end_date, purpose, memo, ri.delete_flag FROM trn_contract_ringi AS cr INNER JOIN trn_ringi_info AS ri ON ri.ringi_no = cr.ringi_no
                        WHERE cr.contract_id = ? AND cr.delete_flag = ?";
        $queryParameter = array($contractId, 1);

        return (new Database())->readQueryExecution($queryString, $queryParameter);
    }
}