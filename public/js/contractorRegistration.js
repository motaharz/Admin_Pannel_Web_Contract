$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
})

var request;
function contractorRegistration(){
    let data = {};
    data["contractorId"] = $("#contractorId").val();
    data["contractorName"] = $("#contractorName").val();
    data["contractorKana"] = $("#contractorKana").val();
    data["contractorPostCode"] = $("#contractorPostCode").val();
    data["contractorAddress1"] = $("#contractorAddress1").val();
    data["contractorAddress2"] = $("#contractorAddress2").val();
    data["contractorPhn"] = $("#contractorPhn").val();
    data["contractorMail"] = $("#contractorMail").val();
    data["temporary"] = $("#temporary").val();

    data["companyId"] = $("#companyId").val();
    data["companyName"] = $("#companyName").val();
    data["companyKana"] = $("#companyKana").val();
    data["companyRepresentative"] = $("#companyRepresentative").val();
    data["companyRepresentativeKana"] = $("#companyRepresentativeKana").val();
    data["companyPostCode"] = $("#companyPostCode").val();
    data["companyAddress1"] = $("#companyAddress1").val();
    data["companyAddress2"] = $("#companyAddress2").val();
    data["companyPhn"] = $("#companyPhn").val();
    data["companyMail"] = $("#companyMail").val();

    data["groupId"] = $("#groupId").val();
    data["groupName"] = $("#groupName").val();
    data["groupKana"] = $("#groupKana").val();
    data["groupRepresentative"] = $("#groupRepresentative").val();
    data["groupRepresentativeKana"] = $("#groupRepresentativeKana").val();
    data["groupPostCode"] = $("#groupPostCode").val();
    data["groupAddress1"] = $("#groupAddress1").val();
    data["groupAddress2"] = $("#groupAddress2").val();
    data["groupPhn"] = $("#groupPhn").val();
    data["groupMail"] = $("#groupMail").val();

    if(validateData(data)){
        if (request) {
            request.abort();
        }

        request = $.ajax({
            url: "/contractor-registration",
            type: "POST",
            data: data,
            dataType:'JSON',

            success: function(data){
                if(data.status === 1){
                    window.location.href = "/home";
                }
            },
            error: function (jqXHR, exception){
                alert("Error occurred");
            }
        });
    }
}

//for searching address from zip code
function contractorAddressSearch () {
    let zipCode = $('#contractorPostCode').val();
    getAddressFromZipCode(zipCode, "contractorAddress1");
}
function companyAddressSearch() {
    let zipCode = $('#companyPostCode').val();
    getAddressFromZipCode(zipCode, "companyAddress1");
}
function groupAddressSearch() {
    let zipCode = $('#groupPostCode').val();
    getAddressFromZipCode(zipCode, "groupAddress1");
}

function getAddressFromZipCode(zipCode, setAddressId){
    var param = {zipcode: zipCode};
    var send_url = "http://zipcloud.ibsnet.co.jp/api/search";

    $.ajax({
        type: "GET",
        cache: false,
        data: param,
        url: send_url,
        dataType: "jsonp",
        success: function (res) {
            if (res.status == 200) {
                if(res.results){
                    $("#"+setAddressId).val(res.results[0].address1 + res.results[0].address2);
                }
                else{
                    alert("Invalid Zip Code");
                }
            }
            else {
                alert(res.message);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
        }
    });
}

function validateData(data) {
    let is_valid = true;

    /*if (fullNameCheck.value == "") {
        document.getElementById("nameerrormsg").style.display = "inline";
        is_valid = false;
    }
    if (addressCheck.value == "") {
        document.getElementById("addrerrormsg").style.display = "inline";
        is_valid = false;
    }
    if (quantityCheck.value == "") {
        document.getElementById("qtyerrormsg").style.display = "inline";
        is_valid = false;
    }*/
    return is_valid;
}

function selectedGroup(data){
    $("#groupId").val($("#groupId"+data).html());
    $("#groupName").val($("#groupName"+data).html());
    $("#groupKana").val($("#groupNameKana"+data).val());
    $("#groupRepresentative").val($("#groupRepresentative"+data).val());
    $("#groupRepresentativeKana").val($("#groupRepresentativeKana"+data).val());
    $("#groupPostCode").val($("#groupPostCode"+data).val());
    $("#groupAddress1").val($("#groupAddress1"+data).html());
    $("#groupAddress2").val($("#groupAddress2"+data).val());
    $("#groupPhn").val($("#groupPhn"+data).html());
    $("#groupMail").val($("#groupMail"+data).html());
}

function selectedCompany(data){
    $("#companyId").val($("#companyId"+data).html());
    $("#companyName").val($("#companyName"+data).html());
    $("#companyKana").val($("#companyNameKana"+data).val());
    $("#companyRepresentative").val($("#companyRepresentative"+data).val());
    $("#companyRepresentativeKana").val($("#companyRepresentativeKana"+data).val());
    $("#companyPostCode").val($("#companyPostCode"+data).val());
    $("#companyAddress1").val($("#companyAddress1"+data).html());
    $("#companyAddress2").val($("#companyAddress2"+data).val());
    $("#companyPhn").val($("#companyPhn"+data).html());
    $("#companyMail").val($("#companyMail"+data).html());
}

function selectedContractor(data){
    $("#contractorId").val($("#contractorId"+data).html());
    $("#contractorName").val($("#contractorName"+data).html());
    $("#contractorKana").val($("#contractorNameKana"+data).val());
    $("#contractorPostCode").val($("#contractorPostCode"+data).val());
    $("#contractorAddress1").val($("#contractorAddress1"+data).html());
    $("#contractorAddress2").val($("#contractorAddress2"+data).val());
    $("#contractorPhn").val($("#contractorPhn"+data).html());
    $("#contractorMail").val($("#contractorMail"+data).html());
}