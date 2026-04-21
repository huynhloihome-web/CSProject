<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShopOrderSuccessNotification extends Notification
{
    use Queueable;

    private $maDonHang;
    private $data;
    private $tongTien;
    private $hinhThucThanhToan;
    private $tenKhachHang;

    public function __construct($maDonHang, $data, $tongTien, $hinhThucThanhToan, $tenKhachHang)
    {
        $this->maDonHang = $maDonHang;
        $this->data = $data;
        $this->tongTien = $tongTien;
        $this->hinhThucThanhToan = $hinhThucThanhToan;
        $this->tenKhachHang = $tenKhachHang;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Đặt hàng thành công')
            ->view('email_template.shop_order_success', [
                'maDonHang' => $this->maDonHang,
                'data' => $this->data,
                'tongTien' => $this->tongTien,
                'hinhThucThanhToan' => $this->hinhThucThanhToan,
                'tenKhachHang' => $this->tenKhachHang,
            ]);
    }
}