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

        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . time() . '.' . $file->getClientOriginalExtension();

        $hasCloudinaryConfig = ! empty(config('filesystems.disks.cloudinary.cloud'))
            || ! empty(config('filesystems.disks.cloudinary.url'))
            || ! empty(env('CLOUDINARY_CLOUD_NAME'))
            || ! empty(env('CLOUDINARY_URL'));

        if ($hasCloudinaryConfig) {
            try {
                $path = $file->storeAs($folder, $filename, 'cloudinary');
                $url = Storage::disk('cloudinary')->url($path);

                if (is_string($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                    return $url;
                }
            } catch (\Throwable $e) {
                \Log::warning('Upload ảnh thất bại trên Cloudinary, chuyển sang local storage: ' . $e->getMessage());
            }
        }

        $path = $file->storeAs($folder, $filename, 'public');

        return str_replace('public/', '', $path);
    }
}