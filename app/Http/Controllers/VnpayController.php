<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;

class VnpayController extends Controller
{
    public function vnpay_payment(Request $request)
    {
      $data = $request->all();
      $code_cart = $request->order_code;
      $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
      $vnp_Returnurl = "http://localhost:8000/";
      $vnp_TmnCode = "1VYBIYQP"; //Mã website tại VNPAY 
      $vnp_HashSecret = "NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1"; //Chuỗi bí mật
  
      $vnp_TxnRef = $code_cart; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
      $vnp_OrderInfo = 'Thanh toán đơn hàng test';
      $vnp_OrderType = 'billpayment';
      $vnp_Amount = $data['total'] * 100;
      $vnp_Locale = 'vn';
      // $vnp_BankCode = 'NCB';
      $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
  
      $inputData = array(
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $vnp_TxnRef,
  
      );
  
      if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
      }
      if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
        $inputData['vnp_Bill_State'] = $vnp_Bill_State;
      }
  
      //var_dump($inputData);
      ksort($inputData);
      $query = "";
      $i = 0;
      $hashdata = "";
      foreach ($inputData as $key => $value) {
        if ($i == 1) {
          $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
          $hashdata .= urlencode($key) . "=" . urlencode($value);
          $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
      }
  
      $vnp_Url = $vnp_Url . "?" . $query;
      if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
      }
      $returnData = array(
        'code' => '00',
        'message' => 'success',
        'data' => $vnp_Url
      );
      if (isset($_POST['redirect'])) {
        return redirect()->to($vnp_Url); 
        // header('Location: ' . $vnp_Url);
        die();
      } else {
        echo json_encode($returnData);
      }
    }
}
