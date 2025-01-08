<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // hiển thị danh sách người dùng
        try {
            $data = User::all();

            if ($data->isEmpty()) {
                return response()->json([
                    "message" => "không có người dùng nào",
                    "data" => []
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => "lấy danh sách người dùng thất bại",
                "error" => $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "lây danh sách người dùng thành công",
            "data" => $data
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $validated = $request->validate([
                'name' => 'required|min:3|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ảnh không bắt buộc
            ]);

            // Xử lý file ảnh nếu có
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                // Di chuyển file ảnh vào thư mục storage/app/public/images
                $image->storeAs('public/images', $image_name);

                // Cập nhật đường dẫn file ảnh vào mảng validated
                $validated['image'] = 'images/' . $image_name;
            }

            // Tạo người dùng từ dữ liệu đã validate
            $data = User::create($validated);

            // Trả về JSON response
            return response()->json([
                "message" => "Tạo người dùng thành công",
                "data" => $data
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lỗi validate
            return response()->json([
                "message" => "Dữ liệu không hợp lệ",
                "errors" => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Lỗi khác
            return response()->json([
                "message" => "Tạo người dùng thất bại",
                "error" => $e->getMessage()
            ], 500);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // lấy người dùng theo id
        try {
            $data = User::find($id);

            if ($data === null) {
                return response()->json([
                    "message" => "Không tìm thấy người dùng",
                    "data" => []
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Lấy người dùng thất bại",
                "error" => $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Lấy người dùng thành công",
            "data" => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cập nhật thông tin người dùng
        try {
            // Validate dữ liệu đầu vào
            $validated = $request->validate([
                'name' => 'min:3|max:255',
                'email' => 'email|unique:users,email,' . $id, // Chỉ kiểm tra uniqueness với ngoại lệ cho người dùng hiện tại
                'password' => 'min:6|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ảnh không bắt buộc
            ]);

            // Lấy người dùng theo id
            $data = User::find($id);

            if ($data === null) {
                return response()->json([
                    "message" => "Không tìm thấy người dùng",
                    "data" => []
                ], 404);
            }

            // Xử lý file ảnh nếu có
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $image_name);

                // Kiểm tra xem người dùng có ảnh đại diện cũ không
                if (!empty($data->image) && file_exists(public_path($data->image))) {
                    // Xóa ảnh cũ
                    unlink(public_path($data->image));
                }

                // Cập nhật đường dẫn file ảnh mới vào validated
                $validated['image'] = 'images/' . $image_name;
            }

            // Cập nhật thông tin người dùng 
            $data->update($validated);

            // Trả về JSON response
            return response()->json([
                "message" => "Cập nhật người dùng thành công",
                "data" => $data
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lỗi validate
            return response()->json([
                "message" => "Dữ liệu không hợp lệ",
                "errors" => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Lỗi khác
            return response()->json([
                "message" => "Cập nhật người dùng thất bại",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // xóa người dùng
        try {
            // Lấy người dùng theo id
            $data = User::find($id);

            if ($data === null) {
                return response()->json([
                    "message" => "Không tìm thấy người dùng",
                    "data" => []
                ], 404);
            }

            // Xóa ảnh đại diện nếu có
            if (!empty($data->image) && file_exists(public_path($data->image))) {
                unlink(public_path($data->image));
            }

            // Xóa người dùng
            $data->delete();

            return response()->json([
                "message" => "Xóa người dùng thành công",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Xóa người dùng thất bại",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
