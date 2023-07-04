<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    protected $table = 'password_resets';
    protected $fillable = [
        'id', 'email', 'token' // THÊM CỘT id vào để sử dụng Eloquent của Laravel cho dễ 
        // thêm vào cả trong table trong database luôn 
    ];
    // 'created_at', 'updated_at' là khi thao tác vs database nó tự đọc ghi , chỉ khi mình sử dụng 
    // model PasswordReset mà có dùng 2 cột này thì mới thêm vào . 
    // còn thêm xóa sửa dữ liệu bằng Model mà không dùng 2 cột này thì không cần ghi vào đây . 
    // Kể các các cột khác vẫn thế . Không dùng thì không ghi vào . 
}
