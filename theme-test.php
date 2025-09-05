<!DOCTYPE html>
<html>
<head>
    <title>Theme Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .theme-test { border: 2px solid #ccc; margin: 10px 0; padding: 15px; }
        .success { color: green; background: #e8f5e8; }
        .error { color: red; background: #ffe8e8; }
    </style>
</head>
<body>
    <h1>OGP Theme Login Flow Test</h1>
    
    <div class="theme-test">
        <h2>Testing Theme Structure</h2>
        <p>This page tests how different themes handle the login transition flow.</p>
        
        <?php
        // Simulate the success message that appears after login
        echo '<div class="success">Successfully logged in. Redirecting to dashboard...</div>';
        ?>
        
        <p>In AdminLTE theme, this content should appear in the main content area, not in the sidebar navigation.</p>
    </div>
    
    <div class="theme-test">
        <h3>Expected Behavior:</h3>
        <ul>
            <li>SimpleBootstrap: Content appears in main area ✓</li>
            <li>AdminLTE: Content should appear in main content area (previously appeared in sidebar)</li>
            <li>Revolution: Content appears in main area ✓</li>
            <li>MasterControlProgram: Content appears in main area ✓</li>
        </ul>
    </div>
</body>
</html>