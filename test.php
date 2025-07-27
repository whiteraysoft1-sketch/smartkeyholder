<?php
// Simple diagnostic file to test if PHP is working
echo "<h1>🔧 Hostinger Diagnostic Test</h1>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Server Time:</strong> " . date('Y-m-d H:i:s') . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";

echo "<h2>File Structure Check:</h2>";
echo "<ul>";
echo "<li>Install folder exists: " . (file_exists('install/') ? '✅ YES' : '❌ NO') . "</li>";
echo "<li>Install/index.php exists: " . (file_exists('install/index.php') ? '✅ YES' : '❌ NO') . "</li>";
echo "<li>Public folder exists: " . (file_exists('public/') ? '✅ YES' : '❌ NO') . "</li>";
echo "<li>Public/index.php exists: " . (file_exists('public/index.php') ? '✅ YES' : '❌ NO') . "</li>";
echo "<li>.env file exists: " . (file_exists('.env') ? '✅ YES' : '❌ NO') . "</li>";
echo "</ul>";

echo "<h2>Quick Links:</h2>";
echo "<ul>";
echo "<li><a href='/install/'>Try /install/</a></li>";
echo "<li><a href='/install/index.php'>Try /install/index.php</a></li>";
echo "<li><a href='/public/install/'>Try /public/install/</a></li>";
echo "<li><a href='/public/'>Try /public/</a></li>";
echo "</ul>";

echo "<p><em>If you see this page, PHP is working correctly!</em></p>";
?>