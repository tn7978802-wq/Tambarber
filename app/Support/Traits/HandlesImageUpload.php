<?php

namespace App\Support\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Dùng chung cho các Controller admin cần cho phép chọn ảnh trực tiếp từ máy
 * tính (ổ C:, thư mục ảnh...) qua thẻ <input type="file">, thay vì phải gõ
 * tay đường dẫn ảnh có sẵn trên server.
 */
trait HandlesImageUpload
{
    /**
     * Lưu file ảnh được tải lên (nếu có) vào disk "public" và trả về đường dẫn
     * public để lưu vào DB (dạng /storage/...). Trả về null nếu người dùng
     * không chọn ảnh mới (giữ nguyên ảnh cũ khi cập nhật).
     */
    protected function storeUploadedImage(Request $request, string $field, string $folder): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);

        if (! $file->isValid()) {
            return null;
        }

        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . time() . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($folder, $filename, 'public');

        return Storage::url($path); // vd: /storage/uploads/hairstyles/fade-169999.jpg
    }
}
