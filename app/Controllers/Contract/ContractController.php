<?php


namespace App\Controllers\Contract;


use App\Controllers\BaseController;
use App\Models\Common\AddressModel;
use App\Models\Contract\ContractModel;
use App\Models\Contractor\ContractorModel;
use App\Models\Ringi\RingiModel;

class ContractController extends BaseController
{
    public function contractSearch(){
        if( session() && session()->get('login') ){
            $prefectures = (new AddressModel())->getAllPrefecture();

            $userType = 0;
            $user = session()->get("userId");
            if(session()->get("user") == "contractor"){
                $userType = 1;
            }

            if($_SERVER['QUERY_STRING']){
                $contractId = $_GET['contractIdSearch'] ?? null;
                $tantouId = $_GET['tantouIdSearch'] ?? null;
                $contractorId = $_GET['contractorIdSearch'] ?? null;
                $contractorName = $_GET['contractorNameSearch'] ?? null;
                $productId = $_GET['productIdSearch'] ?? null;
                $productName = $_GET['productNameSearch'] ?? null;
                $shopId = $_GET['shopIdSearch'] ?? null;
                $shopName = $_GET['shopNameSearch'] ?? null;
                $prefecture = $_GET['prefectureSearch'] ?? null;

                if($contractId != ""){
                    $contract = (new ContractModel())->getContractById($contractId, $userType, $user);
                    if(isset($contract) && count($contract) > 0 ){
                        return redirect()->to("contract-details/".$contractId);
                    }
                    else{
                        return view("Contract/contractSearch", ["title" => "Contract Search", "contracts" => $contract, "prefectures" => $prefectures]);
                    }
                }
                elseif($contractorId != "" || $contractorName != "" || $productId != "" || $productName != "" || $shopId != "" || $shopName != "" || $prefecture != "0" || $prefecture != ""){
                    $contract = (new ContractModel())->getContractBySearchOptions($contractorId, $contractorName, $productId, $productName, $shopId, $shopName, $prefecture, $tantouId, $userType, $user);
                    return view("Contract/contractSearch", ["title" => "Contract Search", "contracts" => $contract, "prefectures" => $prefectures]);
                }
                else{
                    return view("Contract/contractSearch", ["title" => "Contract Search", "contracts" => array(), "prefectures" => $prefectures]);
                }
            }
            else{
                $contract = (new ContractModel())->getAllContract($userType, $user);
                return view("Contract/contractSearch", ["title" => "Contract Search", "contracts" => $contract, "prefectures" => $prefectures]);
            }
        }
        else{
            return redirect()->to("/login");
        }
    }

    public function contractDetails($contractId){
        if( session() && session()->get('login') ){
            $contract = (new ContractModel())->getContractById($contractId);
            $contractDetails = $contract[$contractId] ?? null;

            $contractorDetails = null;
            $ringiDetails = null;

            if(isset($contractDetails) && $contractDetails->getContractorId() ){
                $contractorDetails = (new ContractorModel())->getContractorDetailsById($contractDetails->getContractorId())[0] ?? null;
                $ringiDetails = (new RingiModel())->getRingiByNo($contractDetails->getRingiNo())[0] ?? null;
            }

            $data = array(
                "title" => "Contract Details",
                "contract" => $contractDetails,
                "contractorDetails" => $contractorDetails,
                "ringiDetails" => $ringiDetails
            );

            return view("Contract/contractDetails", $data);
        }
        else{
            return redirect()->to("/login");
        }
    }

    public function contractStatusUpdate($contractId, $status){
        if( session() && session()->get('login') ){
            $updateDate = date("Y-m-d H:i:s");
            $updateUser = session()->get('userId');

            (new ContractModel())->updateContractStatus($contractId, $status, $updateDate, $updateUser);

            return redirect()->to("/contract-details/".$contractId);
        }
        else{
            return redirect()->to("/login");
        }
    }

    public function contractRegistrationSearch(){
        if( session() && session()->get('login') ){
            $contractId = $_GET["contractIdSearch"];
            $contract = (new ContractModel())->getContractById($contractId);

            if(isset($contract) && count($contract) > 0){
                return json_encode(['msg' => "Successful", "contract" => $contract, "status" => 1]);
            }
            else{
                return json_encode(['msg' => "Successful", "contract" => null, "status" => 0]);
            }
        }
        else{
            return redirect()->to("/login");
        }
    }

    public function contractEstimation($contractId){
        if( session() && session()->get('login') ){
            $contract = (new ContractModel())->getContractById($contractId);
            $contractDetails = $contract[$contractId] ?? null;

            return view("Contract/estimation",["title" => "Contract Estimation", "contractDetails" => $contractDetails]);
        }
        else{
            return redirect()->to("/login");
        }
    }

    public function ringiSearch(){
        if( session() && session()->get('login') ) {
            $ringiNo = $_GET["ringiNo"];
            $ringiInfo = (new RingiModel())->getRingiDataByNo($ringiNo);

            if (isset($ringiInfo) && count($ringiInfo) > 0) {
                $ringiInfo = $ringiInfo[0];
                $startDate = $ringiInfo->start_date;
                $endDate = $ringiInfo->end_date;

                $ringiInfo->start_date = date("Y", strtotime($startDate)) . "年" . date("m", strtotime($startDate)) . "月" . date("d", strtotime($startDate)) . "日";
                $ringiInfo->end_date = date("Y", strtotime($endDate)) . "年" . date("m", strtotime($endDate)) . "月" . date("d", strtotime($endDate)) . "日";

                return json_encode(['msg' => "Successful", "ringi" => $ringiInfo, "status" => 1]);
            }
            else {
                return json_encode(['msg' => "Successful", "ringi" => null, "status" => 2]);
            }
        }
        else{
            return json_encode(['msg' => "Not Logged in user", 'status' => 3]);
        }
    }
}