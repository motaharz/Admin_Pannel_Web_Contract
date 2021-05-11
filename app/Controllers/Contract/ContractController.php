<?php


namespace App\Controllers\Contract;


use App\Controllers\BaseController;
use App\Models\Common\AddressModel;
use App\Models\Contract\ContractModel;

class ContractController extends BaseController
{
    public function contractSearch(){
        if( session() && session()->get('login') ){
            $prefectures = (new AddressModel())->getAllPrefecture();
            if($_SERVER['QUERY_STRING']){
                $contractId = $_GET['contractIdSearch'];
                $contractorId = $_GET['contractorIdSearch'];
                $contractorName = $_GET['contractorNameSearch'];
                $productId = $_GET['productIdSearch'];
                $productName = $_GET['productNameSearch'];
                $shopId = $_GET['shopIdSearch'];
                $shopName = $_GET['shopNameSearch'];
                $prefecture = $_GET['prefectureSearch'];

                if($contractId){
                    $contract = (new ContractModel())->getContractById($contractId);
                    return view("Contract/contractSearch", ["title" => "Contract Details", "contracts" => $contract, "prefectures" => $prefectures]);
                }
                elseif($contractorId != "" || $contractorName != "" || $productId != "" || $productName != "" || $shopId != "" || $shopName != "" || $prefecture != 0){
                    $contract = (new ContractModel())->getContractBySearchOptions($contractorId, $contractorName, $productId, $productName, $shopId, $shopName, $prefecture);
                    return view("Contract/contractSearch", ["title" => "Contract Search", "contracts" => $contract, "prefectures" => $prefectures]);
                }
                else{
                    return view("Contract/contractSearch", ["title" => "Contract Search", "contracts" => array(), "prefectures" => $prefectures]);
                }
            }
            else{
                $contract = (new ContractModel())->getAllContract();
                return view("Contract/contractSearch", ["title" => "Contract Search", "contracts" => $contract, "prefectures" => $prefectures]);
            }
        }
        else{
            return redirect()->to("/login");
        }
    }
}