@extends('layouts.app')

@section('content')
<style>
    /* CSS Variables for Theming */
    :root {
        --bg-primary: #f1f5f9;
        --bg-secondary: #ffffff;
        --bg-card: #ffffff;
        --text-primary: #0f172a;
        --text-secondary: #475569;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --sidebar-bg: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.15);
        --shadow-lg: 0 10px 30px rgba(0,0,0,0.2);
        --shadow-card: 0 2px 8px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.06);
        --glow-purple: 0 0 20px rgba(139, 92, 246, 0.3);
        --glow-blue: 0 0 20px rgba(59, 130, 246, 0.3);
        --glow-green: 0 0 20px rgba(34, 197, 94, 0.3);
        --glow-orange: 0 0 20px rgba(249, 115, 22, 0.3);
    }

    .dark {
        --bg-primary: #0f172a;
        --bg-secondary: #1e293b;
        --bg-card: #1e293b;
        --text-primary: #f8fafc;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --border-color: #334155;
        --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #020617 100%);
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.4);
        --shadow-lg: 0 10px 30px rgba(0,0,0,0.5);
        --shadow-card: 0 2px 8px rgba(0,0,0,0.3), 0 4px 16px rgba(0,0,0,0.2);
        --glow-purple: 0 0 30px rgba(139, 92, 246, 0.4);
        --glow-blue: 0 0 30px rgba(59, 130, 246, 0.4);
        --glow-green: 0 0 30px rgba(34, 197, 94, 0.4);
        --glow-orange: 0 0 30px rgba(249, 115, 22, 0.4);
    }

    /* Hide default nav */
    body > div > nav { display: none !important; }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }

    @keyframes glow {
        0%, 100% { box-shadow: var(--shadow-md); }
        50% { box-shadow: var(--glow-purple); }
    }

    /* Admin Wrapper */
    .admin-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        background: var(--bg-primary);
        transition: background 0.3s ease;
        z-index: 9999;
    }

    /* Sidebar */
    .cyber-sidebar {
        width: 224px;
        min-width: 224px;
        background: var(--sidebar-bg);
        color: white;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 100;
        animation: slideInLeft 0.5s ease-out;
        overflow: hidden;
    }

    .cyber-sidebar.collapsed {
        width: 72px;
        min-width: 72px;
    }

    .sidebar-logo {
        padding: 24px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 73px;
    }

    .sidebar-logo h1 {
        font-size: 24px;
        font-weight: 700;
        background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        white-space: nowrap;
        transition: opacity 0.3s ease;
    }

    .cyber-sidebar.collapsed .sidebar-logo h1 {
        font-size: 20px;
    }

    .logo-full {
        display: block;
    }

    .logo-mini {
        display: none;
    }

    .cyber-sidebar.collapsed .logo-full {
        display: none;
    }

    .cyber-sidebar.collapsed .logo-mini {
        display: block;
    }

    .sidebar-nav {
        flex: 1;
        padding: 16px 0;
        overflow-y: auto;
    }

    .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        white-space: nowrap;
    }

    .nav-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(180deg, #8b5cf6, #3b82f6);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .nav-item:hover, .nav-item.active {
        background: rgba(255,255,255,0.1);
        color: white;
    }

    .nav-item:hover::before, .nav-item.active::before {
        transform: scaleY(1);
    }

    .nav-item svg {
        width: 20px;
        height: 20px;
        min-width: 20px;
        margin-right: 12px;
        transition: transform 0.3s ease;
    }

    .nav-item:hover svg {
        transform: scale(1.1);
    }

    .nav-item span {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .cyber-sidebar.collapsed .nav-item {
        padding: 12px 0;
        justify-content: center;
    }

    .cyber-sidebar.collapsed .nav-item svg {
        margin-right: 0;
    }

    .cyber-sidebar.collapsed .nav-item span {
        opacity: 0;
        width: 0;
        overflow: hidden;
        position: absolute;
    }

    /* Tooltip for collapsed sidebar */
    .cyber-sidebar.collapsed .nav-item {
        position: relative;
    }

    .cyber-sidebar.collapsed .nav-item:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        left: 72px;
        background: #1e293b;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 13px;
        white-space: nowrap;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .cyber-sidebar.collapsed .nav-item:hover::before {
        transform: scaleY(1);
    }

    /* Main Content */
    .main-content {
        flex: 1;
        overflow-y: auto;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--bg-primary);
    }

    .main-content.expanded {
        margin-left: 0;
    }

    /* Header */
    .top-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
        animation: fadeIn 0.5s ease-out;
        transition: background 0.3s ease, border-color 0.3s ease;
        flex-wrap: wrap;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-left .mobile-title {
        display: none;
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .desktop-only {
        display: flex;
    }

    .hamburger-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: var(--bg-primary);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-primary);
    }

    .hamburger-btn:hover {
        background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
        color: white;
        transform: scale(1.05);
    }

    .search-box {
        display: flex;
        align-items: center;
        background: var(--bg-primary);
        border-radius: 12px;
        padding: 10px 16px;
        width: 300px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .search-box:focus-within {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
    }

    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        margin-left: 10px;
        color: var(--text-primary);
    }

    .search-box input::placeholder {
        color: var(--text-muted);
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    /* Theme Toggle Button */
    .theme-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-primary);
    }

    .theme-toggle:hover {
        background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
        color: white;
        transform: scale(1.05);
        border-color: transparent;
    }

    .theme-toggle svg {
        width: 20px;
        height: 20px;
        transition: transform 0.3s ease;
    }

    .theme-toggle:hover svg {
        transform: rotate(180deg);
    }

    .dark .theme-toggle:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    }

    .notification-btn {
        position: relative;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-primary);
    }

    .notification-btn:hover {
        background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
        color: white;
        transform: scale(1.05);
        border-color: transparent;
    }

    .notification-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 18px;
        height: 18px;
        background: #ef4444;
        border-radius: 50%;
        font-size: 10px;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-avatar:hover {
        transform: scale(1.05);
        box-shadow: var(--glow-purple);
    }

    /* Dashboard Content */
    .dashboard-content {
        padding: 24px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    /* Animated Stat Cards - Colorful Gradient Design */
    .stat-card {
        border-radius: 16px;
        padding: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out both;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        min-height: 140px;
        border: none;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    /* Gradient backgrounds matching the image */
    .stat-card.gradient-teal {
        background: linear-gradient(135deg, #0d9488 0%, #14b8a6 50%, #2dd4bf 100%);
        box-shadow: 0 8px 32px rgba(13, 148, 136, 0.35);
    }

    .stat-card.gradient-coral {
        background: linear-gradient(135deg, #f97316 0%, #fb923c 40%, #fca5a5 100%);
        box-shadow: 0 8px 32px rgba(249, 115, 22, 0.35);
    }

    .stat-card.gradient-dark {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 50%, #3d5a80 100%);
        box-shadow: 0 8px 32px rgba(30, 58, 95, 0.35);
    }

    .stat-card.gradient-purple {
        background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #a78bfa 100%);
        box-shadow: 0 8px 32px rgba(139, 92, 246, 0.35);
    }

    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
    }

    .stat-card:hover.gradient-teal { box-shadow: 0 12px 40px rgba(13, 148, 136, 0.5); }
    .stat-card:hover.gradient-coral { box-shadow: 0 12px 40px rgba(249, 115, 22, 0.5); }
    .stat-card:hover.gradient-dark { box-shadow: 0 12px 40px rgba(30, 58, 95, 0.5); }
    .stat-card:hover.gradient-purple { box-shadow: 0 12px 40px rgba(139, 92, 246, 0.5); }

    .stat-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        z-index: 1;
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        transition: all 0.3s ease;
        z-index: 1;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
        background: rgba(255, 255, 255, 0.3);
    }

    .stat-value {
        font-size: 40px;
        font-weight: 800;
        color: white;
        margin-bottom: 6px;
        line-height: 1;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-label {
        font-size: 15px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 12px;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        font-size: 13px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.85);
        background: rgba(255, 255, 255, 0.15);
        padding: 6px 12px;
        border-radius: 20px;
        width: fit-content;
        backdrop-filter: blur(5px);
    }

    .stat-trend svg {
        color: white;
    }

    .stat-trend.up { color: rgba(255, 255, 255, 0.95); }
    .stat-trend.down { color: #fecaca; }

    /* Charts Row - Overview + Distribution */
    .charts-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 1024px) {
        .charts-row {
            grid-template-columns: 1fr;
        }
    }

    /* Sales Overview Chart Card */
    .sales-chart-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 24px;
        box-shadow: var(--shadow-card);
        animation: fadeInUp 0.6s ease-out 0.5s both;
    }

    .sales-chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .sales-chart-header h4 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .chart-filter {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        color: var(--text-secondary);
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .chart-filter:hover {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .sales-chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }

    .sales-chart-legend {
        display: flex;
        gap: 24px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
    }

    .legend-color.blue { background: #3b82f6; }
    .legend-color.orange { background: #f97316; }
    .legend-color.green { background: #22c55e; }

    /* Distribution Donut Chart Card */
    .distribution-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 24px;
        box-shadow: var(--shadow-card);
        animation: fadeInUp 0.6s ease-out 0.6s both;
        display: flex;
        flex-direction: column;
    }

    .distribution-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .distribution-header h4 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .distribution-chart-container {
        position: relative;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }

    .donut-center-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }

    .donut-center-label .value {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }

    .donut-center-label .label {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .distribution-legend {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        flex-wrap: wrap;
    }

    .distribution-legend .legend-item {
        font-size: 12px;
    }

    .legend-color.purple { background: #8b5cf6; }
    .legend-color.cyan { background: #06b6d4; }

    /* Gauge Meters Row */
    .gauges-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .gauges-row {
            grid-template-columns: 1fr;
        }
    }

    .gauge-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 24px;
        box-shadow: var(--shadow-card);
        animation: fadeInUp 0.6s ease-out 0.7s both;
        text-align: center;
    }

    .gauge-card h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 20px 0;
    }

    .gauge-container {
        position: relative;
        width: 180px;
        height: 110px;
        margin: 0 auto;
        overflow: hidden;
    }

    .gauge-svg {
        width: 180px;
        height: 180px;
        transform: rotate(-90deg);
    }

    .gauge-bg {
        fill: none;
        stroke: #e5e7eb;
        stroke-width: 12;
        stroke-linecap: round;
    }

    .dark .gauge-bg {
        stroke: #374151;
    }

    .gauge-progress {
        fill: none;
        stroke-width: 12;
        stroke-linecap: round;
        transition: stroke-dashoffset 1s ease-out;
    }

    .gauge-progress.yellow {
        stroke: url(#gaugeGradientYellow);
    }

    .gauge-progress.purple {
        stroke: url(#gaugeGradientPurple);
    }

    .gauge-value {
        position: absolute;
        bottom: 5px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
    }

    .gauge-value .number {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
    }

    .gauge-value .unit {
        font-size: 18px;
        font-weight: 500;
        color: var(--text-secondary);
    }

    .gauge-icon {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 28px;
        height: 28px;
        color: var(--text-muted);
    }

    .gauge-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        padding: 0 10px;
    }

    .gauge-labels span {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    /* Bonus Card */
    .bonus-card {
        background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 50%, #3b82f6 100%);
        border-radius: 20px;
        padding: 28px;
        color: white;
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out 0.5s both;
    }

    .bonus-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    .bonus-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -30%;
        width: 80%;
        height: 80%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 60%);
        animation: float 8s ease-in-out infinite reverse;
    }

    .bonus-content {
        position: relative;
        z-index: 1;
    }

    .bonus-card h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .bonus-card p {
        opacity: 0.9;
        margin-bottom: 20px;
        font-size: 15px;
    }

    .bonus-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: white;
        color: #8b5cf6;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .bonus-btn:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    /* Trial Users Card */
    .trial-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 28px;
        border: 1px solid var(--border-color);
        animation: fadeInUp 0.6s ease-out 0.6s both;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-card);
    }

    .trial-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .trial-card h4 {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 20px;
    }

    .dark .trial-card h4 {
        color: #f8fafc;
    }

    .trial-progress {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .progress-circle {
        position: relative;
        width: 140px;
        height: 140px;
    }

    .progress-circle svg {
        transform: rotate(-90deg);
    }

    .progress-circle .bg {
        fill: none;
        stroke: #e2e8f0;
        stroke-width: 10;
    }

    .dark .progress-circle .bg {
        stroke: #334155;
    }

    .progress-circle .progress {
        fill: none;
        stroke: url(#progressGradient);
        stroke-width: 10;
        stroke-linecap: round;
        stroke-dasharray: 377;
        stroke-dashoffset: calc(377 - (377 * var(--progress)) / 100);
        transition: stroke-dashoffset 1s ease-out;
    }

    .progress-value {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .progress-value .number {
        font-size: 32px;
        font-weight: 700;
        color: #0f172a;
    }

    .dark .progress-value .number {
        color: #f8fafc;
    }

    .progress-value .label {
        font-size: 12px;
        color: #64748b;
    }

    .dark .progress-value .label {
        color: #94a3b8;
    }

    /* Lists */
    .list-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-card);
        animation: fadeInUp 0.6s ease-out both;
        transition: all 0.3s ease;
    }

    .list-card:hover {
        box-shadow: var(--shadow-md);
    }

    .list-card:nth-child(1) { animation-delay: 0.7s; }
    .list-card:nth-child(2) { animation-delay: 0.8s; }

    .list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .list-header h4 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .dark .list-header h4 {
        color: #f8fafc;
    }

    .list-header a {
        color: #8b5cf6;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .list-header a:hover {
        color: #7c3aed;
    }

    .list-item {
        display: flex;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item:hover {
        padding-left: 8px;
    }

    .list-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        margin-right: 14px;
        transition: transform 0.3s ease;
    }

    .list-item:hover .list-avatar {
        transform: scale(1.1);
    }

    .list-info {
        flex: 1;
    }

    .list-info h5 {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .dark .list-info h5 {
        color: #f8fafc;
    }

    .list-info p {
        font-size: 12px;
        color: #64748b;
    }

    .dark .list-info p {
        color: #94a3b8;
    }

    .list-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-active {
        background: rgba(34, 197, 94, 0.15);
        color: #22c55e;
    }

    .badge-trial {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }

    .badge-expired {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }

    /* Quick Actions */
    .quick-actions {
        margin-top: 24px;
        animation: fadeInUp 0.6s ease-out 0.9s both;
    }

    .quick-actions h4 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .dark .quick-actions h4 {
        color: #f8fafc;
    }

    /* Uganda Map Section */
    .map-section {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 24px;
        margin-top: 24px;
        animation: fadeInUp 0.6s ease-out 0.95s both;
    }

    .map-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-card);
    }

    .map-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .map-card .card-header h4 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .dark .map-card .card-header h4 {
        color: #f8fafc;
    }

    .map-card .card-header .menu-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: var(--bg-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }

    .map-card .card-header .menu-btn:hover {
        background: #8b5cf6;
        color: white;
    }

    .uganda-map-container {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 480px;
        border-radius: 12px;
        overflow: hidden;
    }

    /* SimpleMaps SVG Wrapper */
    .simplemaps-wrapper {
        position: relative;
        width: 100%;
        height: 420px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        overflow: hidden;
        cursor: grab;
    }

    .simplemaps-wrapper:active {
        cursor: grabbing;
    }

    .dark .simplemaps-wrapper {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    }

    .map-zoom-container {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: transform 0.3s ease;
        transform-origin: center center;
    }

    .uganda-svg-map {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        pointer-events: none;
    }

    /* Zoom Controls */
    .map-zoom-controls {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        z-index: 10;
    }

    .zoom-btn {
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.95);
        color: #1e293b;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
    }

    .dark .zoom-btn {
        background: rgba(30, 41, 59, 0.95);
        color: #f1f5f9;
    }

    .zoom-btn:hover {
        background: #8b5cf6;
        color: white;
        transform: scale(1.1);
    }

    .zoom-btn:active {
        transform: scale(0.95);
    }

    .zoom-reset {
        font-size: 12px;
        margin-top: 5px;
    }

    .zoom-level {
        font-size: 11px;
        text-align: center;
        padding: 4px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 4px;
        color: #475569;
        font-weight: 500;
    }

    .dark .zoom-level {
        background: rgba(30, 41, 59, 0.9);
        color: #cbd5e1;
    }

    /* Map Markers Overlay */
    .map-markers-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 5;
    }

    .marker {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        transform: translate(-50%, -50%);
        pointer-events: auto;
        cursor: pointer;
        transition: transform 0.2s ease;
        z-index: 6;
    }

    .marker:hover {
        z-index: 10;
    }

    /* Adjusted marker positions to match SimpleMaps Uganda SVG */
    .marker.kampala { top: 62%; left: 52%; }
    .marker.gulu { top: 25%; left: 48%; }
    .marker.mbarara { top: 75%; left: 38%; }
    .marker.jinja { top: 60%; left: 58%; }
    .marker.mbale { top: 50%; left: 65%; }

    .marker-dot {
        width: 12px;
        height: 12px;
        background: #8b5cf6;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.5);
        transition: transform 0.3s ease;
    }

    .marker:hover .marker-dot {
        transform: scale(1.3);
    }

    .marker-dot.pulse {
        background: #22c55e;
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.6);
        animation: markerPulse 2s infinite;
    }

    @keyframes markerPulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.6); }
        70% { box-shadow: 0 0 0 12px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }

    .marker-label {
        font-size: 10px;
        font-weight: 600;
        color: #1e293b;
        background: rgba(255, 255, 255, 0.95);
        padding: 2px 8px;
        border-radius: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        white-space: nowrap;
    }

    .dark .marker-label {
        background: rgba(30, 41, 59, 0.95);
        color: #f1f5f9;
    }

    /* Map Overlay Stats */
    .map-overlay-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 12px 0;
        margin-top: 10px;
    }

    .overlay-stat {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        background: var(--bg-primary);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        color: #0f172a;
        transition: all 0.3s ease;
    }

    .dark .overlay-stat {
        background: #334155;
        color: #f1f5f9;
    }

    .overlay-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .stat-dot.high {
        background: #22c55e;
        box-shadow: 0 0 8px rgba(34, 197, 94, 0.5);
    }

    .stat-dot.medium {
        background: #f59e0b;
        box-shadow: 0 0 8px rgba(245, 158, 11, 0.5);
    }

    .stat-dot.low {
        background: #ef4444;
        box-shadow: 0 0 8px rgba(239, 68, 68, 0.5);
    }

    .map-marker {
        position: absolute;
        width: 16px;
        height: 16px;
        background: #3b82f6;
        border: 3px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    }

    .map-marker:hover {
        transform: scale(1.3);
    }

    .map-marker.kampala { top: 55%; left: 48%; }
    .map-marker.gulu { top: 20%; left: 45%; }
    .map-marker.mbarara { top: 70%; left: 35%; }
    .map-marker.jinja { top: 52%; left: 58%; }
    .map-marker.mbale { top: 45%; left: 70%; }

    .district-stats {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .district-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: var(--bg-primary);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .district-item:hover {
        transform: translateX(5px);
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
    }

    .district-name {
        flex: 1;
        font-size: 14px;
        font-weight: 500;
        color: #0f172a;
    }

    .dark .district-name {
        color: #f8fafc;
    }

    .district-bar-container {
        flex: 2;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .dark .district-bar-container {
        background: #475569;
    }

    .district-bar {
        height: 100%;
        background: linear-gradient(90deg, #22c55e 0%, #4ade80 100%);
        border-radius: 4px;
        transition: width 1s ease-out;
    }

    .district-value {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        min-width: 40px;
        text-align: right;
    }

    .dark .district-value {
        color: #f8fafc;
    }

    .map-legend {
        display: flex;
        gap: 16px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-secondary);
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .legend-dot.high { background: #22c55e; }
    .legend-dot.medium { background: #f59e0b; }
    .legend-dot.low { background: #ef4444; }

    @media (max-width: 1200px) {
        .map-section {
            grid-template-columns: 1fr;
        }
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
    }

    .action-btn {
        padding: 16px 12px;
        border-radius: 14px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        text-align: center;
        color: white;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .action-btn:hover::before {
        left: 100%;
    }

    .action-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .action-btn.purple { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
    .action-btn.blue { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .action-btn.green { background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); }
    .action-btn.indigo { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); }
    .action-btn.orange { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); }

    /* Overlay */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 99;
        backdrop-filter: blur(4px);
    }

    .sidebar-overlay.show {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .content-grid {
            grid-template-columns: 1fr;
        }
        .actions-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        /* Mobile App Layout */
        .admin-wrapper {
            flex-direction: column;
        }

        /* Hide desktop sidebar on mobile */
        .cyber-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            transform: translateX(-100%);
            width: 280px;
            min-width: 280px;
            z-index: 1000;
            border-radius: 0 20px 20px 0;
        }

        .cyber-sidebar.collapsed {
            transform: translateX(-100%);
            width: 280px;
            min-width: 280px;
        }

        .cyber-sidebar.mobile-open {
            transform: translateX(0);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(4px);
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Mobile App Header */
        .main-content {
            margin-left: 0;
            padding: 0;
        }

        .top-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 0 0 24px 24px;
            padding: 16px 20px;
            padding-top: max(16px, env(safe-area-inset-top));
            margin: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            border: none;
            flex-wrap: wrap;
        }

        .dark .top-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .header-left .mobile-title {
            display: block;
            color: white;
            font-size: 20px;
            font-weight: 600;
        }

        .hamburger-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .hamburger-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .desktop-only {
            display: none !important;
        }

        .header-right {
            gap: 8px;
        }

        .theme-toggle, .notification-btn, .profile-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            width: 40px;
            height: 40px;
        }

        .search-box {
            display: none;
        }

        /* Mobile User Profile Card */
        .mobile-profile-card {
            display: flex;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 12px 16px;
            margin: 12px 20px 0;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(10px);
        }

        .mobile-profile-card .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .mobile-profile-card .info {
            flex: 1;
        }

        .mobile-profile-card .name {
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .mobile-profile-card .role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
        }

        .mobile-profile-card .edit-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Dashboard Content Mobile */
        .dashboard-content {
            padding: 20px 16px;
            padding-bottom: 100px; /* Space for bottom nav */
        }

        /* Mobile Stats Grid - 2x2 Grid Layout */
        .stats-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
            margin-bottom: 20px;
        }

        .stat-card {
            padding: 14px !important;
            border-radius: 14px !important;
            min-height: 100px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            position: relative !important;
        }

        .stat-card .stat-content {
            width: 100%;
            padding-right: 40px;
        }

        .stat-value {
            font-size: 22px !important;
            margin-bottom: 2px !important;
        }

        .stat-label {
            font-size: 11px !important;
            margin-bottom: 0 !important;
        }

        .stat-trend {
            display: none !important;
        }

        .stat-icon {
            width: 32px !important;
            height: 32px !important;
            position: absolute !important;
            top: 12px !important;
            right: 12px !important;
            margin: 0 !important;
        }

        .stat-icon svg {
            width: 18px !important;
            height: 18px !important;
        }

        /* Mobile Charts - 2 Column Grid */
        .charts-row {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
            margin-bottom: 16px;
        }

        .sales-chart-card, .distribution-card {
            padding: 12px !important;
            border-radius: 14px !important;
            min-height: 200px;
        }

        .sales-chart-header, .distribution-header {
            margin-bottom: 10px !important;
        }

        .sales-chart-header h4, .distribution-header h4 {
            font-size: 13px !important;
            margin: 0 !important;
        }

        .chart-filter {
            font-size: 9px !important;
            padding: 3px 6px !important;
            display: none;
        }

        .sales-chart-container {
            height: 120px !important;
        }

        .sales-chart-legend {
            gap: 8px !important;
            margin-top: 8px !important;
            padding-top: 8px !important;
            flex-wrap: wrap;
        }

        .sales-chart-legend .legend-item {
            font-size: 9px !important;
        }

        .legend-color {
            width: 8px !important;
            height: 8px !important;
        }

        .distribution-chart-container {
            min-height: 100px !important;
            height: 100px;
        }

        .donut-center-label .value {
            font-size: 16px !important;
        }

        .donut-center-label .label {
            font-size: 9px !important;
        }

        .distribution-legend {
            gap: 6px !important;
            margin-top: 8px !important;
            padding-top: 8px !important;
            flex-wrap: wrap;
        }

        .distribution-legend .legend-item {
            font-size: 9px !important;
        }

        /* Mobile Gauges - 2 Column Grid */
        .gauges-row {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 12px !important;
            margin-bottom: 16px;
        }

        .gauge-card {
            padding: 12px !important;
            border-radius: 14px !important;
            min-height: 140px;
        }

        .gauge-card h4 {
            font-size: 12px !important;
            margin-bottom: 8px !important;
            text-align: center;
        }

        .gauge-container {
            width: 90px !important;
            height: 55px !important;
            margin: 0 auto;
        }

        .gauge-svg {
            width: 90px !important;
            height: 90px !important;
        }

        .gauge-bg, .gauge-progress {
            stroke-width: 10 !important;
        }

        .gauge-value .number {
            font-size: 18px !important;
        }

        .gauge-value .unit {
            font-size: 11px !important;
        }

        .gauge-labels {
            margin-top: 6px !important;
            padding: 0 5px;
        }

        .gauge-labels span {
            font-size: 8px !important;
        }

        /* Mobile Section Headers */
        .mobile-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0 12px;
        }

        .mobile-section-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .mobile-section-header .view-more {
            font-size: 13px;
            color: #3b82f6;
            text-decoration: none;
        }

        /* Mobile Service Grid (like the app image) */
        .mobile-services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin: 16px 0;
        }

        .service-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .service-item .icon-box {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3b82f6;
            transition: all 0.2s ease;
        }

        .service-item:active .icon-box {
            transform: scale(0.95);
            background: #3b82f6;
            color: white;
        }

        .service-item .label {
            font-size: 11px;
            color: var(--text-secondary);
            text-align: center;
            line-height: 1.2;
        }

        /* Mobile Content Grid */
        .content-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .bonus-card {
            padding: 20px;
            border-radius: 16px;
        }

        .bonus-content h3 {
            font-size: 18px;
        }

        .bonus-content p {
            font-size: 13px;
        }

        /* Mobile List Cards */
        .list-card, .map-card {
            padding: 16px;
            border-radius: 16px;
        }

        /* Mobile Quick Actions */
        .actions-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .action-btn {
            padding: 14px 8px;
            font-size: 11px;
            border-radius: 12px;
        }

        /* Bottom Navigation Bar */
        .mobile-bottom-nav {
            display: flex;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--bg-card);
            border-top: 1px solid var(--border-color);
            padding: 8px 0;
            padding-bottom: max(8px, env(safe-area-inset-bottom));
            z-index: 1000;
            justify-content: space-around;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        }

        .dark .mobile-bottom-nav {
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 8px 16px;
            border-radius: 12px;
            text-decoration: none;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }

        .bottom-nav-item.active {
            color: #3b82f6;
        }

        .bottom-nav-item.active .nav-icon {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .bottom-nav-item .nav-icon {
            width: 44px;
            height: 32px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .bottom-nav-item .nav-label {
            font-size: 11px;
            font-weight: 500;
        }

        /* Hide map section on mobile */
        .map-section {
            display: none;
        }

        /* Mobile Notification Badge */
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 18px;
            height: 18px;
            background: #ef4444;
            border-radius: 50%;
            font-size: 10px;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #3b82f6;
        }

        /* Mobile Pending Card */
        .pending-card {
            display: flex;
            background: var(--bg-card);
            border-radius: 16px;
            padding: 16px;
            margin: 16px 0;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow-card);
        }

        .pending-card .icon-wrapper {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
        }

        .pending-card .icon-wrapper .icon-label {
            font-size: 8px;
            font-weight: 500;
            margin-top: 2px;
        }

        .pending-card .content {
            flex: 1;
        }

        .pending-card .title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .pending-card .value {
            font-size: 13px;
            color: var(--text-secondary);
        }
    }

    /* Show bottom nav only on mobile */
    .mobile-bottom-nav {
        display: none;
    }

    .mobile-profile-card {
        display: none;
    }
</style>

<div class="admin-wrapper" id="adminWrapper">
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside class="cyber-sidebar" id="sidebar">
        <div class="sidebar-logo">
            <h1 class="logo-full">SmartQR</h1>
            <h1 class="logo-mini">SQ</h1>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active" data-tooltip="Dashboard">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.qr-codes') }}" class="nav-item" data-tooltip="QR Codes">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                <span>QR Codes</span>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item" data-tooltip="Users">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>Users</span>
            </a>
            <a href="{{ route('admin.subscriptions') }}" class="nav-item" data-tooltip="Subscriptions">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span>Subscriptions</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="nav-item" data-tooltip="Settings">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Settings</span>
            </a>
            <a href="{{ route('admin.qr-codes.export') }}" class="nav-item" data-tooltip="Export Data">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export Data</span>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" class="mt-auto">
                @csrf
                <button type="submit" class="nav-item w-full text-left" data-tooltip="Log out" style="border: none; background: none; cursor: pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Log out</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Header -->
        <header class="top-header">
            <div class="header-left">
                <button class="hamburger-btn" onclick="toggleSidebar()">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h2 class="mobile-title">Home</h2>
                <div class="search-box">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Search...">
                </div>
            </div>
            <div class="header-right">
                <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark/Light Mode" id="themeToggle">
                    <!-- Sun Icon (shown in dark mode) -->
                    <svg class="sun-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <!-- Moon Icon (shown in light mode) -->
                    <svg class="moon-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </button>
                <button class="notification-btn" style="position: relative;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="notification-badge">3</span>
                </button>
                <div class="user-avatar desktop-only">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
            </div>
            
            <!-- Mobile Profile Card (inside header for blue background) -->
            <div class="mobile-profile-card">
                <div class="avatar">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div class="info">
                    <div class="name">{{ Auth::user()->name ?? 'Admin User' }}</div>
                    <div class="role">Administrator</div>
                </div>
                <button class="edit-btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card gradient-teal">
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($stats['total_users']) }}</div>
                        <div class="stat-label">Total Users</div>
                        <div class="stat-trend up">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            <span style="margin-left: 4px;">+12% Since Last Week</span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="stat-card gradient-coral">
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($stats['total_qr_codes']) }}</div>
                        <div class="stat-label">Total QR Codes</div>
                        <div class="stat-trend up">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            <span style="margin-left: 4px;">+8% Since Last Week</span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>
                <div class="stat-card gradient-dark">
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($stats['claimed_qr_codes']) }}</div>
                        <div class="stat-label">Claimed QR Codes</div>
                        <div class="stat-trend up">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            <span style="margin-left: 4px;">+15% Since Last Week</span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                </div>
                <div class="stat-card gradient-purple">
                    <div class="stat-content">
                        <div class="stat-value">{{ number_format($stats['active_subscriptions']) }}</div>
                        <div class="stat-label">Active Subscriptions</div>
                        <div class="stat-trend up">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            <span style="margin-left: 4px;">+5% Since Last Week</span>
                        </div>
                    </div>
                    <div class="stat-icon">
                        <svg width="26" height="26" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Charts Row: Overview + Distribution -->
            <div class="charts-row">
                <!-- Sales Overview Chart -->
                <div class="sales-chart-card">
                    <div class="sales-chart-header">
                        <h4>Overview</h4>
                        <button class="chart-filter">
                            Last 24 Hours
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </div>
                    <div class="sales-chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                    <div class="sales-chart-legend">
                        <div class="legend-item">
                            <span class="legend-color blue"></span>
                            <span>Users</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color orange"></span>
                            <span>QR Codes</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color green"></span>
                            <span>Subscriptions</span>
                        </div>
                    </div>
                </div>

                <!-- Distribution Donut Chart -->
                <div class="distribution-card">
                    <div class="distribution-header">
                        <h4>Coin Distribution</h4>
                    </div>
                    <div class="distribution-chart-container">
                        <canvas id="distributionChart"></canvas>
                        <div class="donut-center-label">
                            <div class="value">{{ number_format($stats['total_qr_codes']) }}</div>
                            <div class="label">Total</div>
                        </div>
                    </div>
                    <div class="distribution-legend">
                        <div class="legend-item">
                            <span class="legend-color blue"></span>
                            <span>Active</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color orange"></span>
                            <span>Claimed</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-color green"></span>
                            <span>Available</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gauge Meters Row -->
            <div class="gauges-row">
                <!-- Active Users Gauge -->
                <div class="gauge-card">
                    <h4>Active Users</h4>
                    <div class="gauge-container">
                        <svg class="gauge-svg" viewBox="0 0 180 180">
                            <defs>
                                <linearGradient id="gaugeGradientYellow" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#f59e0b"/>
                                    <stop offset="100%" style="stop-color:#fbbf24"/>
                                </linearGradient>
                            </defs>
                            <!-- Background arc -->
                            <path class="gauge-bg" d="M 20 90 A 70 70 0 0 1 160 90"/>
                            <!-- Progress arc - 52% of 180 degrees -->
                            <path class="gauge-progress yellow" d="M 20 90 A 70 70 0 0 1 160 90" 
                                  stroke-dasharray="220" 
                                  stroke-dashoffset="105"/>
                        </svg>
                        <div class="gauge-value">
                            <span class="number">{{ $stats['total_users'] > 0 ? round(($stats['active_subscriptions'] / $stats['total_users']) * 100) : 0 }}</span><span class="unit">%</span>
                        </div>
                    </div>
                    <div class="gauge-labels">
                        <span>0%</span>
                        <span>50%</span>
                    </div>
                </div>

                <!-- QR Codes Claimed Gauge -->
                <div class="gauge-card">
                    <h4>QR Codes Claimed</h4>
                    <div class="gauge-container">
                        <svg class="gauge-svg" viewBox="0 0 180 180">
                            <defs>
                                <linearGradient id="gaugeGradientPurple" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#8b5cf6"/>
                                    <stop offset="100%" style="stop-color:#a78bfa"/>
                                </linearGradient>
                            </defs>
                            <!-- Background arc -->
                            <path class="gauge-bg" d="M 20 90 A 70 70 0 0 1 160 90"/>
                            <!-- Progress arc -->
                            <path class="gauge-progress purple" d="M 20 90 A 70 70 0 0 1 160 90" 
                                  stroke-dasharray="220" 
                                  stroke-dashoffset="{{ $stats['total_qr_codes'] > 0 ? 220 - (($stats['claimed_qr_codes'] / $stats['total_qr_codes']) * 220) : 220 }}"/>
                        </svg>
                        <div class="gauge-value">
                            <span class="number">{{ $stats['total_qr_codes'] > 0 ? round(($stats['claimed_qr_codes'] / $stats['total_qr_codes']) * 100) : 0 }}</span><span class="unit">%</span>
                        </div>
                    </div>
                    <div class="gauge-labels">
                        <span>0%</span>
                        <span>100%</span>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <div class="bonus-card">
                    <div class="bonus-content">
                        <h3>Welcome to Admin Dashboard! 🎉</h3>
                        <p>Manage your QR codes, users, and subscriptions efficiently with our powerful admin tools.</p>
                        <a href="{{ route('admin.qr-codes') }}" class="bonus-btn">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            Manage QR Codes
                        </a>
                    </div>
                </div>
                <div class="trial-card">
                    <h4>Trial Users</h4>
                    <div class="trial-progress">
                        <div class="progress-circle" style="--progress: {{ $stats['total_users'] > 0 ? ($stats['trial_users'] / $stats['total_users']) * 100 : 0 }}">
                            <svg width="140" height="140" viewBox="0 0 140 140">
                                <defs>
                                    <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:#8b5cf6"/>
                                        <stop offset="100%" style="stop-color:#3b82f6"/>
                                    </linearGradient>
                                </defs>
                                <circle class="bg" cx="70" cy="70" r="60"/>
                                <circle class="progress" cx="70" cy="70" r="60"/>
                            </svg>
                            <div class="progress-value">
                                <div class="number">{{ $stats['trial_users'] }}</div>
                                <div class="label">Users</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lists Grid -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-top: 24px;">
                <div class="list-card">
                    <div class="list-header">
                        <h4>Recent Users</h4>
                        <a href="{{ route('admin.users') }}">View All</a>
                    </div>
                    @foreach($recentUsers->take(5) as $user)
                    <div class="list-item">
                        <div class="list-avatar" style="background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%); color: white;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="list-info">
                            <h5>{{ $user->name }}</h5>
                            <p>{{ $user->email }}</p>
                        </div>
                        <span class="list-badge badge-active">Active</span>
                    </div>
                    @endforeach
                </div>
                <div class="list-card">
                    <div class="list-header">
                        <h4>Recent Subscriptions</h4>
                        <a href="{{ route('admin.subscriptions') }}">View All</a>
                    </div>
                    @foreach($recentSubscriptions->take(5) as $subscription)
                    <div class="list-item">
                        <div class="list-avatar" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%); color: white;">
                            {{ strtoupper(substr($subscription->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="list-info">
                            <h5>{{ $subscription->user->name ?? 'Unknown' }}</h5>
                            <p>{{ $subscription->plan_type ?? 'Standard' }} Plan</p>
                        </div>
                        <span class="list-badge {{ $subscription->status == 'active' ? 'badge-active' : ($subscription->status == 'trial' ? 'badge-trial' : 'badge-expired') }}">
                            {{ ucfirst($subscription->status ?? 'Active') }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Broadcast Messaging Section -->
            <div style="margin-top: 24px;">
                <div class="messaging-card" style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 24px; box-shadow: var(--shadow-card);">
                    <div class="card-header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                        <h4 style="color: var(--text-primary); font-size: 18px; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>
                            PWA Broadcast Messages
                        </h4>
                        <span style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                            Super Admin
                        </span>
                    </div>

                    @if(session('success'))
                    <div style="background: rgba(34, 197, 94, 0.1); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 12px; padding: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <div style="width: 20px; height: 20px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="12" height="12" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span style="color: #16a34a; font-weight: 500; font-size: 14px;">{{ session('success') }}</span>
                    </div>
                    @endif

                    @if(session('error'))
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 16px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                        <div style="width: 20px; height: 20px; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="12" height="12" fill="none" stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span style="color: #dc2626; font-weight: 500; font-size: 14px;">{{ session('error') }}</span>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.broadcast.send') }}" style="margin-bottom: 20px;">
                        @csrf
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; margin-bottom: 8px; color: var(--text-primary); font-weight: 500; font-size: 14px;">
                                Message to Send to All Users
                            </label>
                            <div style="position: relative;">
                                <input 
                                    type="text" 
                                    name="message" 
                                    id="broadcastMessage"
                                    value="Hello from your PWA! This is a test push notification."
                                    style="width: 100%; padding: 12px 16px; border: 2px solid var(--border-color); border-radius: 10px; background: var(--bg-secondary); color: var(--text-primary); font-size: 14px; transition: all 0.3s ease;" 
                                    placeholder="Enter your broadcast message..."
                                    required
                                    onkeypress="if(event.key==='Enter'){event.preventDefault();document.getElementById('sendBroadcastBtn').click();}"
                                />
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 12px;">
                                    <span id="charCount">0</span>/255
                                </div>
                            </div>
                            @error('message')
                            <span style="color: #ef4444; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="display: flex; gap: 12px; align-items: center;">
                            <button 
                                type="submit"
                                id="sendBroadcastBtn"
                                style="background: linear-gradient(135deg, #8b5cf6 0%, #3b82f6 100%); color: white; border: none; padding: 12px 24px; border-radius: 10px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; font-size: 14px;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(139, 92, 246, 0.4)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'"
                            >
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Send to All Users
                            </button>

                            <button 
                                type="button"
                                onclick="if(confirm('Are you sure you want to clear all broadcast messages?')) { document.getElementById('clearForm').submit(); }"
                                style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 2px solid rgba(239, 68, 68, 0.3); padding: 12px 20px; border-radius: 10px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; font-size: 14px;"
                                onmouseover="this.style.background='rgba(239, 68, 68, 0.15)'"
                                onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'"
                            >
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Clear All Messages
                            </button>

                            <div style="margin-left: auto; color: var(--text-muted); font-size: 13px;">
                                Will send to <strong>{{ $stats['total_users'] }} users</strong>
                            </div>
                        </div>
                    </form>

                    <form id="clearForm" method="POST" action="{{ route('admin.broadcast.clear') }}" style="display: none;">
                        @csrf
                    </form>

                    <div style="background: rgba(139, 92, 246, 0.05); border: 1px solid rgba(139, 92, 246, 0.2); border-radius: 12px; padding: 16px;">
                        <h5 style="color: var(--text-primary); margin: 0 0 8px 0; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            How It Works
                        </h5>
                        <ul style="margin: 0; padding-left: 20px; color: var(--text-secondary); font-size: 13px; line-height: 1.6;">
                            <li>Messages are sent to all users with registered profiles</li>
                            <li>Messages appear as notification banners in user dashboards</li>
                            <li>Users can dismiss messages by clicking the close button</li>
                            <li>Use "Clear All Messages" to remove messages from all users</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Uganda Map Section -->
            <div class="map-section">
                <div class="map-card">
                    <div class="card-header">
                        <h4>Users by District</h4>
                        <button class="menu-btn">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="2" r="1.5"/><circle cx="8" cy="8" r="1.5"/><circle cx="8" cy="14" r="1.5"/></svg>
                        </button>
                    </div>
                    <div class="uganda-map-container">
                        <!-- SimpleMaps Uganda SVG Map -->
                        <div class="simplemaps-wrapper" id="mapWrapper">
                            <!-- Zoom Controls -->
                            <div class="map-zoom-controls">
                                <button class="zoom-btn" onclick="zoomMap(0.2)" title="Zoom In">+</button>
                                <button class="zoom-btn" onclick="zoomMap(-0.2)" title="Zoom Out">−</button>
                                <button class="zoom-btn zoom-reset" onclick="resetMapZoom()" title="Reset">⟲</button>
                                <div class="zoom-level" id="zoomLevel">100%</div>
                            </div>
                            
                            <div class="map-zoom-container" id="mapZoomContainer">
                                <img 
                                    src="https://simplemaps.com/static/svg/country/ug/admin1/ug.svg" 
                                    alt="Uganda Map" 
                                    class="uganda-svg-map"
                                    id="ugandaMap"
                                    draggable="false"
                                />
                            
                                <!-- Dynamic District Markers Overlay -->
                                <div class="map-markers-overlay" id="mapMarkersOverlay">
                                    @php
                                        // Define district positions on the map
                                        $districtPositions = [
                                            'Kampala' => ['top' => '62%', 'left' => '52%'],
                                            'Wakiso' => ['top' => '64%', 'left' => '50%'],
                                            'Gulu' => ['top' => '25%', 'left' => '48%'],
                                            'Mbarara' => ['top' => '75%', 'left' => '38%'],
                                            'Jinja' => ['top' => '60%', 'left' => '58%'],
                                            'Mbale' => ['top' => '50%', 'left' => '65%'],
                                            'Arua' => ['top' => '15%', 'left' => '35%'],
                                            'Lira' => ['top' => '35%', 'left' => '55%'],
                                            'Masaka' => ['top' => '70%', 'left' => '45%'],
                                            'Fort Portal' => ['top' => '55%', 'left' => '35%'],
                                            'Entebbe' => ['top' => '65%', 'left' => '50%'],
                                            'Hoima' => ['top' => '45%', 'left' => '42%'],
                                            'Kasese' => ['top' => '60%', 'left' => '28%'],
                                            'Soroti' => ['top' => '42%', 'left' => '62%'],
                                            'Other' => ['top' => '80%', 'left' => '60%']
                                        ];
                                        $topDistricts = collect($districtStats ?? [])->sortByDesc('user_count')->take(10);
                                    @endphp
                                    
                                    @foreach($topDistricts as $district => $data)
                                        @if(isset($districtPositions[$district]))
                                            <div class="marker {{ strtolower(str_replace(' ', '', $district)) }}" 
                                                 title="{{ $district }}: {{ $data->user_count }} users"
                                                 style="top: {{ $districtPositions[$district]['top'] }}; left: {{ $districtPositions[$district]['left'] }};">
                                                <span class="marker-dot {{ $data->user_count >= 10 ? 'pulse' : '' }}"></span>
                                                <span class="marker-label">{{ $district }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                    
                                    @if(count($topDistricts) == 0)
                                        <!-- Fallback message when no district data -->
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: var(--text-muted);">
                                            <p style="font-size: 14px;">No district data available yet.</p>
                                            <p style="font-size: 12px;">Districts will appear as users register.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dynamic User Activity Stats -->
                        <div class="map-overlay-stats">
                            @foreach(collect($districtStats ?? [])->sortByDesc('user_count')->take(6) as $district => $data)
                                @php
                                    $level = $data->user_count >= 20 ? 'high' : ($data->user_count >= 5 ? 'medium' : 'low');
                                @endphp
                                <div class="overlay-stat">
                                    <span class="stat-dot {{ $level }}"></span>
                                    <span>{{ $district }}: {{ $data->user_count }} users</span>
                                </div>
                            @endforeach
                            
                            @if(count($districtStats ?? []) == 0)
                                <div class="overlay-stat">
                                    <span class="stat-dot low"></span>
                                    <span>No district data yet</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="map-legend">
                        <div class="legend-item">
                            <span class="legend-dot high"></span>
                            High (50+)
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot medium"></span>
                            Medium (25-49)
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot low"></span>
                            Low (<25)
                        </div>
                    </div>
                </div>
                <div class="map-card">
                    <div class="card-header">
                        <h4>Top Districts</h4>
                        <button class="menu-btn">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><circle cx="8" cy="2" r="1.5"/><circle cx="8" cy="8" r="1.5"/><circle cx="8" cy="14" r="1.5"/></svg>
                        </button>
                    </div>
                    <div class="district-stats">
                        <div class="district-item">
                            <span class="district-name">Kampala</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 100%;"></div>
                            </div>
                            <span class="district-value">156</span>
                        </div>
                        <div class="district-item">
                            <span class="district-name">Wakiso</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 57%;"></div>
                            </div>
                            <span class="district-value">89</span>
                        </div>
                        <div class="district-item">
                            <span class="district-name">Mbarara</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 43%;"></div>
                            </div>
                            <span class="district-value">67</span>
                        </div>
                        <div class="district-item">
                            <span class="district-name">Jinja</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 33%;"></div>
                            </div>
                            <span class="district-value">52</span>
                        </div>
                        <div class="district-item">
                            <span class="district-name">Gulu</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 29%;"></div>
                            </div>
                            <span class="district-value">45</span>
                        </div>
                        <div class="district-item">
                            <span class="district-name">Mbale</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 24%;"></div>
                            </div>
                            <span class="district-value">38</span>
                        </div>
                        <div class="district-item">
                            <span class="district-name">Mukono</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 22%;"></div>
                            </div>
                            <span class="district-value">34</span>
                        </div>
                        <div class="district-item">
                            <span class="district-name">Masaka</span>
                            <div class="district-bar-container">
                                <div class="district-bar" style="width: 20%;"></div>
                            </div>
                            <span class="district-value">31</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h4>Quick Actions</h4>
                <div class="actions-grid">
                    <a href="{{ route('admin.qr-codes') }}" class="action-btn purple">Manage QR Codes</a>
                    <a href="{{ route('admin.users') }}" class="action-btn blue">Manage Users</a>
                    <a href="{{ route('admin.subscriptions') }}" class="action-btn green">Subscriptions</a>
                    <a href="{{ route('admin.settings') }}" class="action-btn indigo">Settings</a>
                    <a href="{{ route('admin.qr-codes.export') }}" class="action-btn orange">Export Data</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Bottom Navigation -->
    <nav class="mobile-bottom-nav">
        <a href="{{ route('admin.dashboard') }}" class="bottom-nav-item active">
            <div class="nav-icon">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 00.707-1.707l-9-9a.999.999 0 00-1.414 0l-9 9A1 1 0 003 13zm7 7v-5h4v5h-4zm2-15.586l6 6V20l-4 .002V15a1 1 0 00-1-1h-4a1 1 0 00-1 1v5.002L6 20v-8.586l6-6z"/></svg>
            </div>
            <span class="nav-label">Home</span>
        </a>
        <a href="{{ route('admin.qr-codes') }}" class="bottom-nav-item">
            <div class="nav-icon">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M3 3h8v8H3zm2 2v4h4V5zm8-2h8v8h-8zm2 2v4h4V5zM3 13h8v8H3zm2 2v4h4v-4zm13-2h3v2h-3zm-3 0h2v3h-2zm3 3h3v2h-3zm0 3h3v2h-3zm-3 0h2v2h-2zm-2-3h2v5h-2zm5-3h2v2h-2z"/></svg>
            </div>
            <span class="nav-label">QR Codes</span>
        </a>
        <a href="{{ route('admin.users') }}" class="bottom-nav-item">
            <div class="nav-icon">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <span class="nav-label">Users</span>
        </a>
        <a href="{{ route('admin.settings') }}" class="bottom-nav-item">
            <div class="nav-icon">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.31.06-.63.06-.94 0-.31-.02-.63-.06-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.04.31-.06.63-.06.94s.02.63.06.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
            </div>
            <span class="nav-label">Settings</span>
        </a>
    </nav>
</div>

<script>
    // Sidebar Toggle - Desktop: collapse to icons, Mobile: show/hide
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const overlay = document.getElementById('sidebarOverlay');
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            // Mobile: toggle slide in/out
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
        } else {
            // Desktop: toggle between full width and icon-only
            sidebar.classList.toggle('collapsed');
            
            // Save sidebar state
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
    }

    // Theme Toggle
    function toggleTheme() {
        const wrapper = document.getElementById('adminWrapper');
        const sunIcon = document.querySelector('.sun-icon');
        const moonIcon = document.querySelector('.moon-icon');
        
        wrapper.classList.toggle('dark');
        
        if (wrapper.classList.contains('dark')) {
            sunIcon.style.display = 'block';
            moonIcon.style.display = 'none';
            localStorage.setItem('theme', 'dark');
        } else {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'block';
            localStorage.setItem('theme', 'light');
        }
    }

    // Load saved preferences on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme');
        const savedSidebarState = localStorage.getItem('sidebarCollapsed');
        const wrapper = document.getElementById('adminWrapper');
        const sidebar = document.getElementById('sidebar');
        const sunIcon = document.querySelector('.sun-icon');
        const moonIcon = document.querySelector('.moon-icon');
        
        // Load theme
        if (savedTheme === 'dark') {
            wrapper.classList.add('dark');
            sunIcon.style.display = 'block';
            moonIcon.style.display = 'none';
        } else {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'block';
        }
        
        // Load sidebar state (only on desktop)
        if (window.innerWidth > 768 && savedSidebarState === 'true') {
            sidebar.classList.add('collapsed');
        }
    });

    // Close mobile sidebar when clicking overlay
    document.getElementById('sidebarOverlay').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.remove('mobile-open');
        this.classList.remove('show');
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('show');
        }
    });

    // Map Zoom Functionality
    let mapZoom = 1;
    let mapPanX = 0;
    let mapPanY = 0;
    let isDragging = false;
    let startX, startY;

    function zoomMap(delta) {
        mapZoom = Math.max(0.5, Math.min(3, mapZoom + delta));
        updateMapTransform();
    }

    function resetMapZoom() {
        mapZoom = 1;
        mapPanX = 0;
        mapPanY = 0;
        updateMapTransform();
    }

    function updateMapTransform() {
        const container = document.getElementById('mapZoomContainer');
        const zoomLevelDisplay = document.getElementById('zoomLevel');
        
        if (container) {
            container.style.transform = `translate(${mapPanX}px, ${mapPanY}px) scale(${mapZoom})`;
        }
        
        if (zoomLevelDisplay) {
            zoomLevelDisplay.textContent = Math.round(mapZoom * 100) + '%';
        }
    }

    // Mouse wheel zoom
    document.addEventListener('DOMContentLoaded', function() {
        const mapWrapper = document.getElementById('mapWrapper');
        
        if (mapWrapper) {
            // Mouse wheel zoom
            mapWrapper.addEventListener('wheel', function(e) {
                e.preventDefault();
                const delta = e.deltaY > 0 ? -0.1 : 0.1;
                zoomMap(delta);
            }, { passive: false });

            // Pan with mouse drag
            mapWrapper.addEventListener('mousedown', function(e) {
                if (mapZoom > 1) {
                    isDragging = true;
                    startX = e.clientX - mapPanX;
                    startY = e.clientY - mapPanY;
                    mapWrapper.style.cursor = 'grabbing';
                }
            });

            document.addEventListener('mousemove', function(e) {
                if (isDragging) {
                    mapPanX = e.clientX - startX;
                    mapPanY = e.clientY - startY;
                    
                    // Limit panning based on zoom level
                    const maxPan = (mapZoom - 1) * 150;
                    mapPanX = Math.max(-maxPan, Math.min(maxPan, mapPanX));
                    mapPanY = Math.max(-maxPan, Math.min(maxPan, mapPanY));
                    
                    updateMapTransform();
                }
            });

            document.addEventListener('mouseup', function() {
                isDragging = false;
                if (mapWrapper) {
                    mapWrapper.style.cursor = mapZoom > 1 ? 'grab' : 'default';
                }
            });

            // Touch support for mobile
            let lastTouchDistance = 0;
            
            mapWrapper.addEventListener('touchstart', function(e) {
                if (e.touches.length === 2) {
                    lastTouchDistance = Math.hypot(
                        e.touches[0].clientX - e.touches[1].clientX,
                        e.touches[0].clientY - e.touches[1].clientY
                    );
                } else if (e.touches.length === 1 && mapZoom > 1) {
                    isDragging = true;
                    startX = e.touches[0].clientX - mapPanX;
                    startY = e.touches[0].clientY - mapPanY;
                }
            }, { passive: true });

            mapWrapper.addEventListener('touchmove', function(e) {
                if (e.touches.length === 2) {
                    e.preventDefault();
                    const currentDistance = Math.hypot(
                        e.touches[0].clientX - e.touches[1].clientX,
                        e.touches[0].clientY - e.touches[1].clientY
                    );
                    
                    if (lastTouchDistance > 0) {
                        const delta = (currentDistance - lastTouchDistance) * 0.01;
                        zoomMap(delta);
                    }
                    lastTouchDistance = currentDistance;
                } else if (isDragging && e.touches.length === 1) {
                    mapPanX = e.touches[0].clientX - startX;
                    mapPanY = e.touches[0].clientY - startY;
                    
                    const maxPan = (mapZoom - 1) * 150;
                    mapPanX = Math.max(-maxPan, Math.min(maxPan, mapPanX));
                    mapPanY = Math.max(-maxPan, Math.min(maxPan, mapPanY));
                    
                    updateMapTransform();
                }
            }, { passive: false });

            mapWrapper.addEventListener('touchend', function() {
                isDragging = false;
                lastTouchDistance = 0;
            });

            // Double-click to zoom in
            mapWrapper.addEventListener('dblclick', function(e) {
                e.preventDefault();
                if (mapZoom < 3) {
                    zoomMap(0.5);
                } else {
                    resetMapZoom();
                }
            });
        }
    });
</script>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    // Sales Overview Chart & Distribution Donut Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart');
        const donutCtx = document.getElementById('distributionChart');
        
        // Check if dark mode is active
        const isDarkMode = () => document.getElementById('adminWrapper').classList.contains('dark');

        // Line Chart - Overview
        if (ctx) {
            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['4', '6', '8', '10', '12', '14', '16', '18', '20', '22', '24'],
                    datasets: [
                        {
                            label: 'Users',
                            data: [47, 45, 48, 33, 42, 53, 37, 45, 52, 48, 51],
                            borderColor: '#3b82f6',
                            backgroundColor: 'transparent',
                            borderWidth: 2.5,
                            fill: false,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: '#3b82f6',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 2
                        },
                        {
                            label: 'QR Codes',
                            data: [20, 22, 25, 22, 28, 35, 25, 30, 40, 33, 35],
                            borderColor: '#f97316',
                            backgroundColor: 'transparent',
                            borderWidth: 2.5,
                            fill: false,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#f97316',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: '#f97316',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDarkMode() ? '#1e293b' : '#fff',
                            titleColor: isDarkMode() ? '#f8fafc' : '#0f172a',
                            bodyColor: isDarkMode() ? '#cbd5e1' : '#475569',
                            borderColor: isDarkMode() ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            usePointStyle: true
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: isDarkMode() ? 'rgba(51, 65, 85, 0.3)' : 'rgba(226, 232, 240, 0.6)',
                            },
                            ticks: {
                                color: isDarkMode() ? '#94a3b8' : '#9ca3af',
                                font: { size: 11 }
                            },
                            border: { display: false }
                        },
                        y: {
                            min: 15,
                            max: 60,
                            grid: {
                                color: isDarkMode() ? 'rgba(51, 65, 85, 0.3)' : 'rgba(226, 232, 240, 0.6)',
                            },
                            ticks: {
                                color: isDarkMode() ? '#94a3b8' : '#9ca3af',
                                font: { size: 11 },
                                stepSize: 10
                            },
                            border: { display: false }
                        }
                    }
                }
            });

            // Store reference for theme updates
            window.salesChart = salesChart;
        }

        // Donut Chart - Distribution
        if (donutCtx) {
            const distributionChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Claimed', 'Available'],
                    datasets: [{
                        data: [35, 40, 25],
                        backgroundColor: [
                            '#3b82f6',  // Blue
                            '#f97316',  // Orange
                            '#22c55e'   // Green
                        ],
                        borderColor: isDarkMode() ? '#1e293b' : '#ffffff',
                        borderWidth: 4,
                        hoverBorderWidth: 4,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDarkMode() ? '#1e293b' : '#fff',
                            titleColor: isDarkMode() ? '#f8fafc' : '#0f172a',
                            bodyColor: isDarkMode() ? '#cbd5e1' : '#475569',
                            borderColor: isDarkMode() ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    }
                }
            });

            // Store reference for theme updates
            window.distributionChart = distributionChart;
        }

        // Update chart colors when theme changes
        const originalToggleTheme = window.toggleTheme;
        window.toggleTheme = function() {
            originalToggleTheme();
            setTimeout(() => {
                const dark = isDarkMode();
                
                // Update sales chart
                if (window.salesChart) {
                    window.salesChart.options.plugins.tooltip.backgroundColor = dark ? '#1e293b' : '#fff';
                    window.salesChart.options.plugins.tooltip.titleColor = dark ? '#f8fafc' : '#0f172a';
                    window.salesChart.options.plugins.tooltip.bodyColor = dark ? '#cbd5e1' : '#475569';
                    window.salesChart.options.plugins.tooltip.borderColor = dark ? '#334155' : '#e2e8f0';
                    window.salesChart.options.scales.x.ticks.color = dark ? '#94a3b8' : '#9ca3af';
                    window.salesChart.options.scales.y.ticks.color = dark ? '#94a3b8' : '#9ca3af';
                    window.salesChart.options.scales.x.grid.color = dark ? 'rgba(51, 65, 85, 0.3)' : 'rgba(226, 232, 240, 0.6)';
                    window.salesChart.options.scales.y.grid.color = dark ? 'rgba(51, 65, 85, 0.3)' : 'rgba(226, 232, 240, 0.6)';
                    window.salesChart.update();
                }
                
                // Update distribution chart
                if (window.distributionChart) {
                    window.distributionChart.data.datasets[0].borderColor = dark ? '#1e293b' : '#ffffff';
                    window.distributionChart.options.plugins.tooltip.backgroundColor = dark ? '#1e293b' : '#fff';
                    window.distributionChart.options.plugins.tooltip.titleColor = dark ? '#f8fafc' : '#0f172a';
                    window.distributionChart.options.plugins.tooltip.bodyColor = dark ? '#cbd5e1' : '#475569';
                    window.distributionChart.options.plugins.tooltip.borderColor = dark ? '#334155' : '#e2e8f0';
                    window.distributionChart.update();
                }
            }, 100);
        };
    });

    // Broadcast Message Character Counter
    document.addEventListener('DOMContentLoaded', function() {
        const messageInput = document.getElementById('broadcastMessage');
        const charCount = document.getElementById('charCount');
        
        if (messageInput && charCount) {
            function updateCharCount() {
                const count = messageInput.value.length;
                charCount.textContent = count;
                
                // Change color based on length
                if (count > 200) {
                    charCount.style.color = '#ef4444';
                } else if (count > 150) {
                    charCount.style.color = '#f59e0b';
                } else {
                    charCount.style.color = 'var(--text-muted)';
                }
            }
            
            // Update on input
            messageInput.addEventListener('input', updateCharCount);
            
            // Initial count
            updateCharCount();
        }
    });
</script>
@endsection
