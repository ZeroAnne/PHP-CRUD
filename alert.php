<?php
session_start();
session_destroy();
if (isset($_SESSION['message'])) {
  // 
  if ($_SESSION['message'] == '資料已存在') {
    echo '<script>
    Swal.fire({
        title: "新增失敗",
        text: "資料已存在，請使用更新功能",
        icon: "error",
        confirmButtonColor: "#fd7e14"
      });
    </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '圖片上傳檔案錯誤') {
    echo '<script>
    Swal.fire({
        title: "新增失敗",
        text: "圖片上傳檔案錯誤",
        icon: "error",
        confirmButtonColor: "#fd7e14"
      });
    </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '欄位不可為空') {
    echo '<script>
    Swal.fire({
        title: "新增失敗",
        text: "欄位不可為空",
        icon: "error",
        confirmButtonColor: "#fd7e14"
      });
    </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '新增資料成功') {
    $id = $_SESSION['addId'];
    echo '<script>
    Swal.fire({
        title: "新增成功",
        text: "最新一筆序號為' . $id . '",
        icon: "success",
        confirmButtonColor: "#fd7e14"
      });
    </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '新增資料錯誤') {
    echo '<script>
    Swal.fire({
        title: "新增失敗",
        icon: "error",
        confirmButtonColor: "#fd7e14"
      });
    </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '更新圖片失敗') {
    echo '<script>
  Swal.fire({
      title: "更新圖片失敗",
      icon: "error",
      confirmButtonColor: "#fd7e14"
    });
  </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '更新圖片成功') {
    echo '<script>
  Swal.fire({
      title: "更新圖片成功",
      icon: "success",
      confirmButtonColor: "#fd7e14"
    });
  </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '刪除成功') {
    echo '<script>
  Swal.fire({
      title: "刪除資料成功",
      icon: "success",
      confirmButtonColor: "#fd7e14"
    });
  </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '刪除失敗') {
    echo '<script>
  Swal.fire({
      title: "刪除資料失敗",
      icon: "error",
      confirmButtonColor: "#fd7e14"
    });
  </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '編輯資料失敗') {
    echo '<script>
  Swal.fire({
      title: "編輯資料失敗",
      icon: "error",
      confirmButtonColor: "#fd7e14"
    });
  </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '編輯資料成功') {
    echo '<script>
  Swal.fire({
      title: "編輯資料成功",
      icon: "success",
      confirmButtonColor: "#fd7e14"
    });
  </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] == '新增票卷資料成功') {
    $last_id = $_SESSION['addId'];
    echo '<script>
  Swal.fire({
      title: "新增成功",
      text: "最新一筆序號為' . $last_id . '",
      icon: "success"
    });
  </script>';
    unset($_SESSION['message']);
  } elseif ($_SESSION['message'] = "使用者不存在")
    echo '<script>
  Swal.fire({
      title: "無使用者",
      icon: "error"
    });
  </script>';
  unset($_SESSION['message']);
}
