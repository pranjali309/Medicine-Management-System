<?php
$file = "uploads/1742206950_sakshiiii.jpg";
if (file_exists($file)) {
    echo "✅ File Exists: <img src='$file' width='200'>";
} else {
    echo "❌ File Not Found in `uploads/` Folder";
}
?>
