<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Smart KeyHolder WST V1 - Whiteray Smart Tag</title>
    @vite(['resources/css/app.css', 'resources/css/liquid-glass.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #000000;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            color: white;
            overflow-x: hidden;
        }

        .gradient-bg {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background: 
                radial-gradient(ellipse at top left, #0a0a0a 0%, #000000 40%),
                radial-gradient(ellipse at top right, #111111 0%, #000000 40%),
                radial-gradient(ellipse at bottom left, #0d0d0d 0%, #000000 40%),
                radial-gradient(ellipse at bottom right, #080808 0%, #000000 40%),
                radial-gradient(ellipse at center, #050505 0%, #000000 60%),
                linear-gradient(135deg, #000000 0%, #0a0a0a 25%, #111111 50%, #0a0a0a 75%, #000000 100%);
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 15% 15%, rgba(59, 130, 246, 0.15) 0%, transparent 20%),
                radial-gradient(circle at 85% 20%, rgba(139, 92, 246, 0.12) 0%, transparent 25%),
                radial-gradient(circle at 40% 70%, rgba(236, 72, 153, 0.08) 0%, transparent 30%),
                radial-gradient(circle at 80% 80%, rgba(34, 197, 94, 0.06) 0%, transparent 20%),
                radial-gradient(circle at 20% 90%, rgba(251, 191, 36, 0.04) 0%, transparent 25%),
                radial-gradient(circle at 60% 30%, rgba(168, 85, 247, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 30% 60%, rgba(14, 165, 233, 0.07) 0%, transparent 25%);
            z-index: 1;
            animation: backgroundShift 20s ease-in-out infinite;
        }

        .gradient-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                linear-gradient(45deg, transparent 40%, rgba(255, 255, 255, 0.008) 50%, transparent 60%),
                linear-gradient(-45deg, transparent 40%, rgba(59, 130, 246, 0.015) 50%, transparent 60%),
                linear-gradient(90deg, transparent 30%, rgba(139, 92, 246, 0.01) 50%, transparent 70%);
            z-index: 2;
            animation: shimmer 20s linear infinite;
        }

        @keyframes backgroundShift {
            0%, 100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
            25% {
                transform: scale(1.1) rotate(1deg);
                opacity: 0.8;
            }
            50% {
                transform: scale(1.05) rotate(-0.5deg);
                opacity: 0.9;
            }
            75% {
                transform: scale(1.08) rotate(0.8deg);
                opacity: 0.85;
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%);
            }
            100% {
                transform: translateX(100%) translateY(100%);
            }
        }

        .chat-bubble {
            animation: slideInUp 0.6s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
            animation-delay: calc(var(--delay, 0) * 0.1s);
        }

        .chat-bubble.user {
            animation: slideInRight 0.6s ease-out;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .pattern-bg {
            background-image:
                radial-gradient(circle at 1px 1px, rgba(255,255,255,0.03) 0.5px, transparent 0),
                radial-gradient(circle at 8px 8px, rgba(59,130,246,0.02) 0.5px, transparent 0),
                radial-gradient(circle at 15px 15px, rgba(139,92,246,0.015) 0.5px, transparent 0);
            background-size: 40px 40px, 80px 80px, 120px 120px;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 3;
            animation: patternMove 40s linear infinite;
        }

        @keyframes patternMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(30px, 30px); }
        }

        .content-container {
            position: relative;
            z-index: 10;
        }

        .typing-indicator { display: none; }
        .typing-indicator.show { display: flex; animation: slideInUp 0.3s ease-out; }
        .dot { animation: typing 1.4s infinite ease-in-out; }
        .dot:nth-child(1) { animation-delay: -0.32s; }
        .dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes typing {
            0%,80%,100% { transform: scale(0); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
        }

        .input-container { display: none; }
        .input-container.active { display: block; animation: slideInUp 0.6s ease-out; }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 4;
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
            filter: blur(1px);
        }

        .floating-element:nth-child(1) {
            background: radial-gradient(circle, rgba(59,130,246,0.2) 0%, rgba(59,130,246,0.05) 50%, transparent 100%);
            animation-duration: 12s;
        }

        .floating-element:nth-child(2) {
            background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, rgba(139,92,246,0.04) 50%, transparent 100%);
            animation-duration: 15s;
        }

        .floating-element:nth-child(3) {
            background: radial-gradient(circle, rgba(236,72,153,0.12) 0%, rgba(236,72,153,0.03) 50%, transparent 100%);
            animation-duration: 10s;
        }

        .floating-element:nth-child(4) {
            background: radial-gradient(circle, rgba(34,197,94,0.1) 0%, rgba(34,197,94,0.025) 50%, transparent 100%);
            animation-duration: 18s;
        }

        .floating-element:nth-child(5) {
            background: radial-gradient(circle, rgba(251,191,36,0.08) 0%, rgba(251,191,36,0.02) 50%, transparent 100%);
            animation-duration: 14s;
        }

        .floating-element:nth-child(6) {
            background: radial-gradient(circle, rgba(168,85,247,0.1) 0%, rgba(168,85,247,0.025) 50%, transparent 100%);
            animation-duration: 16s;
        }

        .floating-element:nth-child(7) {
            background: radial-gradient(circle, rgba(14,165,233,0.09) 0%, rgba(14,165,233,0.02) 50%, transparent 100%);
            animation-duration: 20s;
        }

        .floating-element:nth-child(8) {
            background: radial-gradient(circle, rgba(99,102,241,0.07) 0%, rgba(99,102,241,0.018) 50%, transparent 100%);
            animation-duration: 22s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg) scale(1); 
                opacity: 0.6;
            }
            25% { 
                transform: translateY(-30px) translateX(20px) rotate(90deg) scale(1.1); 
                opacity: 0.8;
            }
            50% { 
                transform: translateY(-15px) translateX(-25px) rotate(180deg) scale(0.9); 
                opacity: 1;
            }
            75% { 
                transform: translateY(-40px) translateX(15px) rotate(270deg) scale(1.05); 
                opacity: 0.7;
            }
        }

        .pulse-glow {
            animation: pulseGlow 3s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            from { 
                box-shadow: 0 0 20px rgba(59,130,246,0.4), 0 0 40px rgba(59,130,246,0.2); 
                filter: brightness(1);
            }
            to { 
                box-shadow: 0 0 30px rgba(59,130,246,0.8), 0 0 60px rgba(59,130,246,0.4); 
                filter: brightness(1.2);
            }
        }

        /* Particle system */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 2;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: particleFloat 20s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0px);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-10px) translateX(100px);
                opacity: 0;
            }
        }

        /* Interactive background effects */
        :root {
            --mouse-x: 0.5;
            --mouse-y: 0.5;
        }

        .gradient-bg::before {
            background:
                radial-gradient(circle at calc(var(--mouse-x) * 100%) calc(var(--mouse-y) * 100%), rgba(59, 130, 246, 0.12) 0%, transparent 25%),
                radial-gradient(circle at 15% 15%, rgba(59, 130, 246, 0.15) 0%, transparent 20%),
                radial-gradient(circle at 85% 20%, rgba(139, 92, 246, 0.12) 0%, transparent 25%),
                radial-gradient(circle at 40% 70%, rgba(236, 72, 153, 0.08) 0%, transparent 30%),
                radial-gradient(circle at 80% 80%, rgba(34, 197, 94, 0.06) 0%, transparent 20%),
                radial-gradient(circle at 20% 90%, rgba(251, 191, 36, 0.04) 0%, transparent 25%),
                radial-gradient(circle at 60% 30%, rgba(168, 85, 247, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 30% 60%, rgba(14, 165, 233, 0.07) 0%, transparent 25%);
        }

        /* Enhanced mobile performance */
        @media (max-width: 768px) {
            .gradient-bg::before {
                animation-duration: 30s; /* Slower animation on mobile */
            }
            
            .floating-element {
                animation-duration: 12s; /* Slower floating on mobile */
            }
            
            .particle {
                animation-duration: 25s; /* Slower particles on mobile */
            }
        }

        /* Aurora Effect */
        .aurora-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .aurora {
            position: absolute;
            width: 200%;
            height: 100%;
            opacity: 0.3;
            filter: blur(2px);
            mix-blend-mode: screen;
        }

        .aurora-1 {
            background: linear-gradient(45deg, 
                transparent 0%, 
                rgba(59, 130, 246, 0.08) 25%, 
                rgba(139, 92, 246, 0.12) 50%, 
                rgba(236, 72, 153, 0.06) 75%, 
                transparent 100%);
            animation: aurora1 30s ease-in-out infinite;
            transform: rotate(-10deg);
        }

        .aurora-2 {
            background: linear-gradient(-45deg, 
                transparent 0%, 
                rgba(34, 197, 94, 0.05) 30%, 
                rgba(59, 130, 246, 0.08) 60%, 
                rgba(168, 85, 247, 0.06) 90%, 
                transparent 100%);
            animation: aurora2 35s ease-in-out infinite reverse;
            transform: rotate(15deg);
        }

        .aurora-3 {
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(251, 191, 36, 0.03) 20%, 
                rgba(236, 72, 153, 0.05) 50%, 
                rgba(139, 92, 246, 0.04) 80%, 
                transparent 100%);
            animation: aurora3 40s ease-in-out infinite;
            transform: rotate(-5deg);
        }

        @keyframes aurora1 {
            0%, 100% { 
                transform: translateX(-50%) translateY(-10%) rotate(-10deg) scale(1); 
                opacity: 0.2;
            }
            33% { 
                transform: translateX(-30%) translateY(-5%) rotate(-8deg) scale(1.1); 
                opacity: 0.4;
            }
            66% { 
                transform: translateX(-70%) translateY(-15%) rotate(-12deg) scale(0.9); 
                opacity: 0.3;
            }
        }

        @keyframes aurora2 {
            0%, 100% { 
                transform: translateX(-60%) translateY(5%) rotate(15deg) scale(1); 
                opacity: 0.15;
            }
            50% { 
                transform: translateX(-40%) translateY(-8%) rotate(18deg) scale(1.2); 
                opacity: 0.3;
            }
        }

        @keyframes aurora3 {
            0%, 100% { 
                transform: translateX(-45%) translateY(-5%) rotate(-5deg) scale(1); 
                opacity: 0.1;
            }
            25% { 
                transform: translateX(-55%) translateY(3%) rotate(-3deg) scale(1.1); 
                opacity: 0.2;
            }
            75% { 
                transform: translateX(-35%) translateY(-12%) rotate(-7deg) scale(0.95); 
                opacity: 0.15;
            }
        }

        /* Reduced motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            .gradient-bg::before,
            .gradient-bg::after,
            .floating-element,
            .particle,
            .pattern-bg,
            .aurora {
                animation: none;
            }
            
            .pulse-glow {
                animation: none;
            }
        }

        /* Enhanced Input Field UI */
        .input-field-container {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .input-wrapper {
            position: relative;
            margin-bottom: 0;
        }

        .button-spacer {
            height: 24px; /* Space between input and button */
            background: linear-gradient(180deg, 
                rgba(255, 255, 255, 0.02) 0%, 
                transparent 50%, 
                rgba(59, 130, 246, 0.01) 100%);
            border-radius: 4px;
            margin: 8px 0;
        }

        .button-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .enhanced-input {
            position: relative;
            z-index: 2;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .enhanced-input:focus {
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 
                0 0 0 3px rgba(59, 130, 246, 0.1),
                0 8px 32px rgba(59, 130, 246, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .input-focus-ring {
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            border-radius: inherit;
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.3) 0%, 
                rgba(139, 92, 246, 0.3) 50%, 
                rgba(236, 72, 153, 0.3) 100%);
            opacity: 0;
            z-index: 1;
            transition: opacity 0.3s ease;
            filter: blur(8px);
        }

        .enhanced-input:focus + .input-focus-ring {
            opacity: 1;
            animation: focusRingPulse 2s ease-in-out infinite;
        }

        @keyframes focusRingPulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.02); opacity: 0.6; }
        }

        .enhanced-btn {
            position: relative;
            overflow: hidden;
            min-width: 160px;
            padding: 16px 32px;
            border-radius: 16px;
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.9) 0%, 
                rgba(139, 92, 246, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .enhanced-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 12px 40px rgba(59, 130, 246, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .enhanced-btn:active {
            transform: translateY(-1px) scale(0.98);
            transition: all 0.1s ease;
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            z-index: 2;
        }

        .btn-text {
            font-weight: 600;
            font-size: 16px;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .btn-icon {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .enhanced-btn:hover .btn-icon {
            transform: translateX(4px);
        }

        .btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.2) 0%, 
                transparent 50%, 
                rgba(59, 130, 246, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: inherit;
        }

        .enhanced-btn:hover .btn-glow {
            opacity: 1;
            animation: btnGlowPulse 2s ease-in-out infinite;
        }

        @keyframes btnGlowPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.01); }
        }

        /* Enhanced mobile performance */
        @media (max-width: 768px) {
            .gradient-bg::before {
                animation-duration: 30s; /* Slower animation on mobile */
            }
            
            .floating-element {
                animation-duration: 12s; /* Slower floating on mobile */
            }
            
            .particle {
                animation-duration: 25s; /* Slower particles on mobile */
            }
            
            .aurora {
                opacity: 0.2; /* Reduced opacity on mobile */
                filter: blur(3px); /* More blur on mobile */
            }
            
            .aurora-1 { animation-duration: 35s; }
            .aurora-2 { animation-duration: 40s; }
            .aurora-3 { animation-duration: 45s; }

            /* Mobile input adjustments */
            .button-spacer {
                height: 20px;
                margin: 6px 0;
            }

            .enhanced-btn {
                min-width: 140px;
                padding: 14px 28px;
                border-radius: 14px;
            }

            .btn-text {
                font-size: 15px;
            }

            .enhanced-input {
                padding: 16px;
                font-size: 16px; /* Prevent zoom on iOS */
            }

            /* Mobile completion adjustments */
            .completion-btn {
                min-width: 280px;
                padding: 18px 24px;
            }

            .completion-btn-text {
                font-size: 16px;
            }

            .completion-spacer {
                height: 20px;
            }
        }

        /* Completion Section Styles */
        .completion-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 8px;
        }

        .completion-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 0;
        }

        .completion-icon {
            position: relative;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.9) 0%, 
                rgba(59, 130, 246, 0.9) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 
                0 8px 32px rgba(34, 197, 94, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            animation: completionIconPulse 2s ease-in-out infinite;
        }

        .icon-glow {
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.4) 0%, 
                rgba(59, 130, 246, 0.4) 100%);
            border-radius: 50%;
            filter: blur(8px);
            opacity: 0.6;
            animation: iconGlowPulse 3s ease-in-out infinite;
        }

        @keyframes completionIconPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes iconGlowPulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }

        .completion-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .completion-subtitle {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0;
        }

        .completion-spacer {
            height: 32px;
            width: 100%;
            background: linear-gradient(180deg, 
                rgba(255, 255, 255, 0.03) 0%, 
                transparent 50%, 
                rgba(34, 197, 94, 0.02) 100%);
            border-radius: 8px;
            margin: 16px 0;
        }

        .completion-button-wrapper {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .completion-btn {
            position: relative;
            overflow: hidden;
            min-width: 320px;
            padding: 20px 32px;
            border-radius: 20px;
            background: linear-gradient(135deg, 
                rgba(34, 197, 94, 0.95) 0%, 
                rgba(59, 130, 246, 0.95) 50%,
                rgba(139, 92, 246, 0.95) 100%);
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            box-shadow: 
                0 8px 32px rgba(34, 197, 94, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .completion-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 
                0 16px 48px rgba(34, 197, 94, 0.4),
                0 8px 32px rgba(59, 130, 246, 0.3),
                0 0 0 2px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .completion-btn:active {
            transform: translateY(-2px) scale(0.98);
            transition: all 0.1s ease;
        }

        .completion-btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .completion-btn-icon {
            font-size: 24px;
            animation: rocketBounce 2s ease-in-out infinite;
        }

        @keyframes rocketBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        .completion-btn-text {
            font-weight: 700;
            font-size: 18px;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .completion-btn-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.3) 0%, 
                transparent 50%, 
                rgba(34, 197, 94, 0.2) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            border-radius: inherit;
        }

        .completion-btn:hover .completion-btn-glow {
            opacity: 1;
            animation: completionBtnGlowPulse 2s ease-in-out infinite;
        }

        @keyframes completionBtnGlowPulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.01); }
        }

        .completion-btn-particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.3) 1px, transparent 1px),
                radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.2) 1px, transparent 1px),
                radial-gradient(circle at 40% 60%, rgba(255, 255, 255, 0.25) 1px, transparent 1px);
            background-size: 30px 30px, 40px 40px, 50px 50px;
            opacity: 0;
            border-radius: inherit;
            animation: particleFloat 4s linear infinite;
        }

        .completion-btn:hover .completion-btn-particles {
            opacity: 1;
        }

        @keyframes particleFloat {
            0% { transform: translate(0, 0); }
            100% { transform: translate(20px, -20px); }
        }
    </style>
</head>
<body class="gradient-bg">
    <!-- Background Pattern -->
    <div class="pattern-bg"></div>

    <!-- Aurora Effect -->
    <div class="aurora-container">
        <div class="aurora aurora-1"></div>
        <div class="aurora aurora-2"></div>
        <div class="aurora aurora-3"></div>
    </div>

    <!-- Particle System -->
    <div class="particles" id="particles"></div>

    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-element w-24 h-24 sm:w-32 sm:h-32" style="top: 10%; left: 8%; animation-delay: 0s;"></div>
        <div class="floating-element w-32 h-32 sm:w-40 sm:h-40" style="top: 15%; right: 12%; animation-delay: 2s;"></div>
        <div class="floating-element w-20 h-20 sm:w-24 sm:h-24" style="bottom: 25%; left: 15%; animation-delay: 4s;"></div>
        <div class="floating-element w-28 h-28 sm:w-36 sm:h-36" style="bottom: 8%; right: 10%; animation-delay: 1s;"></div>
        <div class="floating-element w-36 h-36 sm:w-44 sm:h-44" style="top: 45%; left: 20%; animation-delay: 3s;"></div>
        <div class="floating-element w-40 h-40 sm:w-48 sm:h-48" style="bottom: 35%; right: 25%; animation-delay: 5s;"></div>
        <div class="floating-element w-16 h-16 sm:w-20 sm:h-20" style="top: 70%; left: 70%; animation-delay: 6s;"></div>
        <div class="floating-element w-22 h-22 sm:w-28 sm:h-28" style="top: 30%; right: 45%; animation-delay: 7s;"></div>
    </div>

    <!-- Main Content -->
    <div class="content-container min-h-screen py-4 px-3 sm:py-8 sm:px-6">
        <!-- Header -->
        <div class="max-w-lg mx-auto mb-6 sm:mb-8 animate-fade-in">
            <div class="liquid-glass enhanced text-center">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center shadow-lg animate-pulse-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 sm:h-8 sm:w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white mb-2">Smart KeyHolder WST V1</h1>
                <p class="text-white/80 text-sm sm:text-base">Your Digital Identity Awaits</p>
            </div>
        </div>

        <!-- Chat Container -->
        <div class="max-w-2xl mx-auto px-2 sm:px-0">
            <div id="chatContainer" class="space-y-3 sm:space-y-4 mb-6 min-h-[300px] sm:min-h-[400px]"></div>

            <!-- Typing Indicator -->
            <div class="typing-indicator flex items-start space-x-2 sm:space-x-3 mb-4 sm:mb-6 px-2 sm:px-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0">AI</div>
                <div class="liquid-glass-dark rounded-xl sm:rounded-2xl rounded-tl-sm p-3 sm:p-4 max-w-[80%]">
                    <div class="flex space-x-1 sm:space-x-2">
                        <div class="w-2 h-2 bg-white/60 rounded-full dot"></div>
                        <div class="w-2 h-2 bg-white/60 rounded-full dot"></div>
                        <div class="w-2 h-2 bg-white/60 rounded-full dot"></div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('qr.claim.process', $qrCode->uuid) }}" id="claimForm">
                @csrf
                @if ($errors->any())
                    <div class="mx-2 sm:mx-0 mb-4 sm:mb-6">
                        <div class="liquid-glass enhanced border border-red-400/30 animate-fade-in">
                            <div class="flex items-start text-red-100 mb-3">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold text-sm sm:text-base">Please fix the following:</span>
                            </div>
                            <ul class="list-disc list-inside text-red-100 text-sm space-y-1 ml-7">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Hidden Fields -->
                <input type="hidden" name="name" id="hiddenName">
                <input type="hidden" name="email" id="hiddenEmail">
                <input type="hidden" name="password" id="hiddenPassword">
                <input type="hidden" name="password_confirmation" id="hiddenPasswordConfirmation">
                <input type="hidden" name="profession" id="hiddenProfession">
                <input type="hidden" name="phone" id="hiddenPhone">
                <input type="hidden" name="website" id="hiddenWebsite">
                <input type="hidden" name="location" id="hiddenLocation">
                <input type="hidden" name="bio" id="hiddenBio">

                <!-- Input Container -->
                <div id="inputContainer" class="input-container px-2 sm:px-0"></div>
            </form>
        </div>

        <!-- QR Preview -->
        <div id="qrPreview" class="max-w-lg mx-auto mt-6 sm:mt-8 px-2 sm:px-0" style="display: none;">
            <div class="liquid-glass enhanced text-center animate-fade-in">
                <h3 class="text-white font-bold mb-4 text-lg sm:text-xl">Your QR Code</h3>
                <div class="bg-white p-3 sm:p-4 rounded-xl inline-block mb-4 shadow-lg">
                    <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-28 h-28 sm:w-32 sm:h-32 mx-auto">
                </div>
                <p class="text-white/80 text-sm sm:text-base">Code: <span class="font-mono font-semibold">{{ $qrCode->code }}</span></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 sm:mt-8 max-w-lg mx-auto px-2 sm:px-0">
            <div class="liquid-glass-dark text-xs sm:text-sm text-white/70 leading-relaxed">
                By claiming this profile, you agree to our
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors underline decoration-dotted">Terms of Service</a> and
                <a href="#" class="text-blue-300 hover:text-blue-200 transition-colors underline decoration-dotted">Privacy Policy</a>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 0;
        let conversationData = {};
        const conversation = [
            {
                question: "Hello! Welcome to your new Smart KeyHolder WST V1! 🎉 What's your name?",
                field: "name",
                type: "text",
                placeholder: "Enter your full name",
                validation: (value) => value.trim().length >= 2,
                errorMessage: "Please enter your full name (at least 2 characters)",
                response: (value) => `Nice to meet you, ${value}! 😊` },
            {
                question: "Now I need your email address to create your account.",
                field: "email",
                type: "email",
                placeholder: "your.email@example.com",
                validation: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value),
                errorMessage: "Please enter a valid email address",
                response: (value) => `Perfect! ${value} looks great.` },
            {
                question: "Let's secure your account with a strong password.",
                field: "password",
                type: "password",
                placeholder: "Create a secure password",
                validation: (value) => value.length >= 8,
                errorMessage: "Password must be at least 8 characters long",
                response: () => "Excellent! Your account is now secure. 🔒" },
            {
                question: "Please confirm your password to make sure it's correct.",
                field: "password_confirmation",
                type: "password",
                placeholder: "Confirm your password",
                validation: (value) => value === conversationData.password,
                errorMessage: "Passwords don't match. Please try again.",
                response: () => "Great! Passwords match perfectly. ✅" },
            {
                question: "What's your profession or job title? (This helps people know what you do)",
                field: "profession",
                type: "text",
                placeholder: "e.g., Software Developer, Designer, Entrepreneur",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? `${value} sounds amazing! 🚀` : "No problem, you can add this later if you want." },
            {
                question: "What's your phone number? (Optional, but helpful for contacts)",
                field: "phone",
                type: "tel",
                placeholder: "+1 (555) 123-4567",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? "Perfect! People can now call you directly. 📞" : "That's okay, you can add this later." },
            {
                question: "Do you have a website or portfolio you'd like to share?",
                field: "website",
                type: "url",
                placeholder: "https://yourwebsite.com",
                validation: (value) => !value || /^https?:\/\/.+/.test(value),
                errorMessage: "Please enter a valid website URL (starting with http:// or https://)",
                response: (value) => value ? "Awesome! Your website will be featured on your profile. 🌐" : "No worries, you can add this anytime." },
            {
                question: "Where are you located? (City, Country)",
                field: "location",
                type: "text",
                placeholder: "e.g., New York, USA",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? `${value} - what a great place! 📍` : "That's fine, location is optional." },
            {
                question: "Finally, tell people a bit about yourself! What makes you unique?",
                field: "bio",
                type: "textarea",
                placeholder: "Write a short bio about yourself...",
                validation: () => true,
                errorMessage: "",
                response: (value) => value ? "Wonderful! Your bio will help people connect with you. ✨" : "You can always add a bio later when inspiration strikes!" }
        ];

        function showTyping() {
            document.querySelector('.typing-indicator').classList.add('show');
        }

        function hideTyping() {
            document.querySelector('.typing-indicator').classList.remove('show');
        }

        function addChatMessage(message, isUser = false, delay = 0) {
            setTimeout(() => {
                const chatContainer = document.getElementById('chatContainer');
                const messageDiv = document.createElement('div');

                if (isUser) {
                    messageDiv.className = 'chat-bubble user flex items-start space-x-2 sm:space-x-3 justify-end px-2 sm:px-0';
                    messageDiv.innerHTML = `
                        <div class="liquid-glass-dark rounded-xl sm:rounded-2xl rounded-tr-sm p-3 sm:p-4 max-w-[80%] sm:max-w-md">
                            <p class="text-white text-sm sm:text-base leading-relaxed">${message}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-r from-green-500 to-teal-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0">You</div>
                    `;
                } else {
                    messageDiv.className = 'chat-bubble flex items-start space-x-2 sm:space-x-3 px-2 sm:px-0';
                    messageDiv.style.setProperty('--delay', delay);
                    messageDiv.innerHTML = `
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm flex-shrink-0">AI</div>
                        <div class="liquid-glass-dark rounded-xl sm:rounded-2xl rounded-tl-sm p-3 sm:p-4 max-w-[80%] sm:max-w-md">
                            <p class="text-white text-sm sm:text-base leading-relaxed">${message}</p>
                        </div>
                    `;
                }

                chatContainer.appendChild(messageDiv);
                // Smooth scroll with better mobile handling
                setTimeout(() => {
                    messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            }, delay);
        }

        function createInputField(step) {
            const stepData = conversation[step];
            const container = document.getElementById('inputContainer');
            let inputHTML;

            if (stepData.type === 'textarea') {
                inputHTML = `
                    <div class="liquid-glass enhanced animate-slide-up">
                        <div class="input-field-container">
                            <div class="input-wrapper">
                                <textarea id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input enhanced-input resize-none" rows="4" autocomplete="off"></textarea>
                                <div class="input-focus-ring"></div>
                            </div>
                            <div class="button-spacer"></div>
                            <div class="button-wrapper">
                                <button type="button" onclick="processAnswer()" class="liquid-btn enhanced-btn">
                                    <div class="btn-content">
                                        <span class="btn-text">Continue</span>
                                        <div class="btn-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="btn-glow"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                inputHTML = `
                    <div class="liquid-glass enhanced animate-slide-up">
                        <div class="input-field-container">
                            <div class="input-wrapper">
                                <input type="${stepData.type}" id="currentInput" placeholder="${stepData.placeholder}" class="liquid-input enhanced-input" autocomplete="off">
                                <div class="input-focus-ring"></div>
                            </div>
                            <div class="button-spacer"></div>
                            <div class="button-wrapper">
                                <button type="button" onclick="processAnswer()" class="liquid-btn enhanced-btn">
                                    <div class="btn-content">
                                        <span class="btn-text">Continue</span>
                                        <div class="btn-icon">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="btn-glow"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }

            container.innerHTML = inputHTML;
            container.classList.add('active');

            // Smooth scroll to input on mobile
            setTimeout(() => {
                const input = document.getElementById('currentInput');
                input.focus();
                input.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);

            document.getElementById('currentInput').addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && stepData.type !== 'textarea') {
                    e.preventDefault();
                    processAnswer();
                }
            });
        }

        function processAnswer() {
            const input = document.getElementById('currentInput');
            const value = input.value.trim();
            const stepData = conversation[currentStep];

            // Special handling for password confirmation
            if (stepData.field === 'password_confirmation') {
                console.log('Confirming password: ', value, 'Original password: ', conversationData.password);
                if (value !== conversationData.password) {
                    input.style.borderColor = 'rgba(239, 68, 68, 0.5)';
                    input.placeholder = "Passwords don't match. Please try again.";
                    input.value = '';
                    return;
                }
                // Set both conversationData and hidden field
                conversationData.password_confirmation = value;
                document.getElementById('hiddenPasswordConfirmation').value = value;
            } else if (stepData.field === 'password') {
                // Set both conversationData and hidden field
                conversationData.password = value;
                document.getElementById('hiddenPassword').value = value;
            } else if (!stepData.validation(value)) {
                if (stepData.errorMessage) {
                    input.style.borderColor = 'rgba(239, 68, 68, 0.5)';
                    input.placeholder = stepData.errorMessage;
                    input.value = '';
                    return;
                }
            } else {
                conversationData[stepData.field] = value;
                document.getElementById('hidden' + stepData.field.charAt(0).toUpperCase() + stepData.field.slice(1)).value = value;
            }

            // For password fields, show asterisks instead of the actual password in the chat
            let displayValue = value;
            if (stepData.type === 'password' && value) {
                displayValue = '••••••••';
            }

            addChatMessage(displayValue || "I'll skip this for now", true);
            document.getElementById('inputContainer').classList.remove('active');

            setTimeout(() => {
                showTyping();
                setTimeout(() => {
                    hideTyping();
                    const response = stepData.response(value);
                    addChatMessage(response);

                    setTimeout(() => {
                        currentStep++;
                        if (currentStep < conversation.length) {
                            showTyping();
                            setTimeout(() => {
                                hideTyping();
                                addChatMessage(conversation[currentStep].question);
                                setTimeout(() => { createInputField(currentStep); }, 1000);
                            }, 1500);
                        } else {
                            showFinalStep();
                        }
                    }, 1200);
                }, 1800);
            }, 500);
        }

        function showFinalStep() {
            showTyping();
            setTimeout(() => {
                hideTyping();
                addChatMessage("🎉 Fantastic! You're all set up. Let me create your Smart KeyHolder profile now...");

                setTimeout(() => {
                    document.getElementById('qrPreview').style.display = 'block';
                    document.getElementById('qrPreview').scrollIntoView({ behavior: 'smooth' });
                }, 1000);

                setTimeout(() => {
                    addChatMessage("Your Smart KeyHolder is ready! Click below to activate it and start sharing your digital identity. 🚀");

                    setTimeout(() => {
                        const container = document.getElementById('inputContainer');
                        container.innerHTML = `
                            <div class="liquid-glass enhanced animate-slide-up">
                                <div class="completion-container">
                                    <div class="completion-header">
                                        <div class="completion-icon">
                                            <div class="icon-glow"></div>
                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <h3 class="completion-title">Ready to Launch! 🎉</h3>
                                        <p class="completion-subtitle">30-day free trial • No credit card required</p>
                                    </div>
                                    <div class="completion-spacer"></div>
                                    <div class="completion-button-wrapper">
                                        <button type="button" onclick="submitClaimForm()" class="completion-btn">
                                            <div class="completion-btn-content">
                                                <span class="completion-btn-icon">🚀</span>
                                                <span class="completion-btn-text">Activate My Smart KeyHolder</span>
                                            </div>
                                            <div class="completion-btn-glow"></div>
                                            <div class="completion-btn-particles"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.classList.add('active');
                    }, 1000);
                }, 2000);
            }, 1500);
        }

        function submitClaimForm() {
            console.log('Submitting form with data:', {
                name: conversationData.name,
                email: conversationData.email,
                password: '********', // Don't log actual password
                password_confirmation: '********',
                hiddenPassword: document.getElementById('hiddenPassword').value ? 'Set' : 'Not set',
                hiddenPasswordConfirmation: document.getElementById('hiddenPasswordConfirmation').value ? 'Set' : 'Not set'
            });

            // Verify password and confirmation match before submitting
            if (conversationData.password !== conversationData.password_confirmation) {
                alert("Password and confirmation don't match. Please start over.");
                return;
            }

            // Double-check all required fields are filled
            if (!conversationData.name || !conversationData.email || !conversationData.password) {
                alert("Please fill in all required fields (name, email, password).");
                return;
            }

            // Ensure hidden fields are properly set
            document.getElementById('hiddenName').value = conversationData.name;
            document.getElementById('hiddenEmail').value = conversationData.email;
            document.getElementById('hiddenPassword').value = conversationData.password;
            document.getElementById('hiddenPasswordConfirmation').value = conversationData.password_confirmation;

            // Submit the form
            try {
                // Add a debug message to the page
                const debugDiv = document.createElement('div');
                debugDiv.style.display = 'none';
                debugDiv.innerHTML = `
                    <p>Name: ${document.getElementById('hiddenName').value ? 'Set' : 'Not set'}</p>
                    <p>Email: ${document.getElementById('hiddenEmail').value ? 'Set' : 'Not set'}</p>
                    <p>Password: ${document.getElementById('hiddenPassword').value ? 'Set' : 'Not set'}</p>
                    <p>Password Confirmation: ${document.getElementById('hiddenPasswordConfirmation').value ? 'Set' : 'Not set'}</p>
                `;
                document.body.appendChild(debugDiv);

                document.getElementById('claimForm').submit();
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('An error occurred while submitting the form. Please try again.');
            }
        }

        // Particle System
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = window.innerWidth < 768 ? 15 : 25; // Fewer particles on mobile
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                // Random starting position
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                
                // Random particle properties
                const size = Math.random() * 3 + 1;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                
                // Random colors for particles - galaxy themed
                const colors = [
                    'rgba(59, 130, 246, 0.4)',
                    'rgba(139, 92, 246, 0.35)',
                    'rgba(236, 72, 153, 0.3)',
                    'rgba(34, 197, 94, 0.25)',
                    'rgba(251, 191, 36, 0.2)',
                    'rgba(255, 255, 255, 0.3)',
                    'rgba(14, 165, 233, 0.3)',
                    'rgba(168, 85, 247, 0.25)'
                ];
                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
                
                // Add subtle glow
                particle.style.boxShadow = `0 0 ${size * 2}px ${particle.style.background}`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // Enhanced background interaction
        function addBackgroundInteraction() {
            let mouseX = 0;
            let mouseY = 0;
            
            document.addEventListener('mousemove', (e) => {
                mouseX = e.clientX / window.innerWidth;
                mouseY = e.clientY / window.innerHeight;
                
                // Update CSS custom properties for mouse-based effects
                document.documentElement.style.setProperty('--mouse-x', mouseX);
                document.documentElement.style.setProperty('--mouse-y', mouseY);
            });
            
            // Touch interaction for mobile
            document.addEventListener('touchmove', (e) => {
                if (e.touches.length > 0) {
                    mouseX = e.touches[0].clientX / window.innerWidth;
                    mouseY = e.touches[0].clientY / window.innerHeight;
                    
                    document.documentElement.style.setProperty('--mouse-x', mouseX);
                    document.documentElement.style.setProperty('--mouse-y', mouseY);
                }
            });
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            // Create particle system
            createParticles();
            
            // Add background interaction
            addBackgroundInteraction();
            
            // Start the chat
            setTimeout(() => {
                addChatMessage(conversation[0].question);
                setTimeout(() => { createInputField(0); }, 1000);
            }, 1000);
        });
    </script>
</body>
</html>
