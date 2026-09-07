<?php

namespace App\Support\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Dùng chung cho các Controller admin cần cho phép chọn ảnh/GIF trực tiếp từ máy
 * tính qua thẻ <input type="file"> và tự động tải lên Cloudinary để lưu trữ vĩnh viễn.
 */
trait HandlesImageUpload
{
    /**
     * Lưu file ảnh/GIF được tải lên (nếu có) vào disk "cloudinary" và trả về đường dẫn
     * URL tuyệt đối của Cloudinary để lưu vào DB. Trả về null nếu người dùng
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

        // Tạo tên file an toàn (giữ nguyên extension bao gồm cả .gif, .png, .jpg, .webp)
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Tải file (Ảnh / GIF) trực tiếp lên Cloudinary
        $path = $file->storeAs($folder, $filename, 'cloudinary');

        // Trả về đường dẫn URL tuyệt đối từ Cloudinary
        return Storage::disk('cloudinary')->url($path);
    }
}