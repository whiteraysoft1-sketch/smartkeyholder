@php
use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.dashboard')

@section('content')
    <style>
        /* Adaptive Apple-Style Liquid Glass Dashboard */
        .dashboard-container {
            min-height: 100vh;
            background: #ffffff !important;
            position: relative;
            overflow-x: hidden;
            transition: background-color 0.3s ease;
            color: #1f2937 !important;
        }

        .dashboard-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(168, 85, 247, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        .dashboard-header {
            position: sticky;
            top: 0;
            z-index: 30;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .dashboard-content {
            max-width: 28rem;
            margin: 0 auto;
            padding: 0 1rem 3rem 1rem;
        }

        .collapsible-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            margin-bottom: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        /* For browsers that don't support backdrop-filter */
        @supports not (backdrop-filter: blur(20px)) {
            .collapsible-card {
                background: #ffffff;
            }
        }

        .collapsible-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        } 
                rgba(255, 255, 255, 0.98) 0%, 
                rgba(255, 255, 255, 0.85) 35%,
                rgba(255, 255, 255, 0.8) 65%,
                rgba(255, 255, 255, 0.95) 100%);
            backdrop-filter: blur(40px) saturate(220%) brightness(1.15);
            border-top: 2px solid rgba(255, 255, 255, 0.9);
            border-left: 2px solid rgba(255, 255, 255, 0.7);
        }

        .card-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.4) 0%, 
                rgba(255, 255, 255, 0.2) 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.3) 0%, 
                transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-header:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header:hover::before {
            opacity: 1;
        }

        .card-header:active {
            transform: translateY(0);
            transition: transform 0.1s ease;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 700;
            font-size: 1.125rem;
            color: #1f2937 !important;
            margin: 0;
        }

        .card-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, 
                rgba(59, 130, 246, 0.9) 0%, 
                rgba(99, 102, 241, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 1.25rem;
            box-shadow: 
                0 4px 15px rgba(59, 130, 246, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .card-status {
            font-size: 0.75rem;
            padding: 0.375rem 0.875rem;
            border-radius: 16px;
            font-weight: 600;
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, 0.2);
            backdrop-filter: blur(10px);
        }

        .expand-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            color: #6b7280;
            backdrop-filter: blur(10px);
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .expand-icon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 100%;
            height: 100%;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .expand-icon:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .expand-icon:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .expand-icon.expanded {
            transform: rotate(180deg);
            background: rgba(59, 130, 246, 0.15);
            color: #3b82f6;
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .expand-icon.expanded::before {
            transform: translate(-50%, -50%) scale(1);
            background: rgba(59, 130, 246, 0.2);
        }

        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .card-content {
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            opacity: 0;
            transform: translateY(-10px);
        }

        .card-content.expanded {
            max-height: 3000px;
            opacity: 1;
            transform: translateY(0);
        }

        .card-content-inner {
            padding: 0 1.5rem 1.5rem;
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.2) 0%, 
                rgba(255, 255, 255, 0.1) 100%);
        }

        /* Force Light Theme - Override any dark mode preferences */
        * {
            color-scheme: light !important;
        }
        
        body {
            background: #ffffff !important;
            color: #1f2937 !important;
        }

        /* Form and Input Styling for Light Theme */
        input, select, textarea, button {
            background: #ffffff !important;
            color: #1f2937 !important;
            border-color: #d1d5db !important;
        }

        input:focus, select:focus, textarea:focus {
            background: #ffffff !important;
            color: #1f2937 !important;
            border-color: #3b82f6 !important;
            outline: 0 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }

        label {
            color: #374151 !important;
        }

        /* Ensure all text is light theme */
        .form-label, .card-text, p, span, div {
            color: #1f2937 !important;
        }

        /* Override any dark backgrounds */
        .bg-dark, .dark {
            background: #ffffff !important;
            color: #1f2937 !important;
        }

        /* Override Tailwind gray text classes */
        .text-gray-600, .text-gray-700, .text-gray-500, .text-gray-800, .text-gray-900 {
            color: #374151 !important;
        }

        /* Ensure QR code container background is always light */
        .qr-code-container {
            background: #ffffff !important;
            color: #1f2937 !important;
        }

        /* Force all text elements to light theme colors */
        * {
            color-scheme: light !important;
        }

        /* Clean Modern Buttons */
        .liquid-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            border: none;
            color: white;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
            position: relative;
        }

        .liquid-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px -2px rgba(59, 130, 246, 0.4);
            background: linear-gradient(135deg, #2563eb 0%, #5b21b6 100%);
        }

        /* Enhanced Liquid Glass Buttons */
        .liquid-glass-btn {
            position: relative;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.8) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            color: #374151;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .liquid-glass-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .liquid-glass-btn.btn-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.9) 0%, rgba(5, 150, 105, 0.9) 100%);
            color: white;
            border-color: rgba(255, 255, 255, 0.2);
        }

        .liquid-glass-btn.btn-success:hover {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.95) 0%, rgba(5, 150, 105, 0.95) 100%);
            box-shadow: 0 12px 48px rgba(16, 185, 129, 0.4);
        }

        .liquid-glass-btn.btn-primary {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.9) 0%, rgba(99, 102, 241, 0.9) 100%);
            color: white;
            border-color: rgba(255, 255, 255, 0.2);
        }

        .liquid-glass-btn.btn-primary:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.95) 0%, rgba(99, 102, 241, 0.95) 100%);
            box-shadow: 0 12px 48px rgba(59, 130, 246, 0.4);
        }

        .btn-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .btn-icon {
            font-size: 0.875rem;
        }

        .btn-text {
            font-weight: 600;
            letter-spacing: 0.025em;
        }

        .btn-shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .liquid-glass-btn:hover .btn-shine {
            left: 100%;
        }

        /* Enhanced Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 28px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #e2e8f0, #cbd5e1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 28px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        input:checked + .toggle-slider {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: inset 0 2px 4px rgba(59, 130, 246, 0.3), 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(22px);
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2), 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        input:focus + .toggle-slider {
            outline: none;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        input:checked:focus + .toggle-slider {
            box-shadow: inset 0 2px 4px rgba(59, 130, 246, 0.3), 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .liquid-input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: rgba(255, 255, 255, 0.8);
        }

        .liquid-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .liquid-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .qr-code-container {
            text-align: center;
            padding: 2.5rem;
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.95) 0%, 
                rgba(249, 250, 251, 0.85) 35%,
                rgba(249, 250, 251, 0.8) 65%,
                rgba(255, 255, 255, 0.95) 100%);
            backdrop-filter: blur(30px) saturate(180%) brightness(1.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid rgba(255, 255, 255, 0.8);
            border-left: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 28px;
            margin-bottom: 1.5rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 10px 25px rgba(0, 0, 0, 0.08),
                0 4px 12px rgba(0, 0, 0, 0.04),
                inset 0 3px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(255, 255, 255, 0.4),
                inset 3px 0 0 rgba(255, 255, 255, 0.3),
                inset -1px 0 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .qr-code-image {
            width: 10rem;
            height: 10rem;
            border-radius: 24px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.15),
                0 8px 20px rgba(0, 0, 0, 0.1),
                0 0 0 2px rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.6);
            margin: 0 auto 1.5rem;
            background: white;
            padding: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        @media (max-width: 640px) {
            .quick-actions {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
        }

        .action-btn {
            padding: 0.75rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Apple-Style Status Elements */
        .notification-banner {
            background: linear-gradient(145deg, 
                rgba(59, 130, 246, 0.2) 0%, 
                rgba(59, 130, 246, 0.1) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #1f2937;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 
                0 8px 25px rgba(59, 130, 246, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .status-banner {
            background: linear-gradient(145deg, 
                rgba(16, 185, 129, 0.2) 0%, 
                rgba(16, 185, 129, 0.1) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: rgba(255, 255, 255, 0.9);
            padding: 1rem 1.5rem;
            border-radius: 16px;
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            box-shadow: 
                0 8px 25px rgba(16, 185, 129, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .gallery-item {
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            background: #f3f4f6;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* Animation improvements */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-content.expanded .card-content-inner {
            animation: slideDown 0.3s ease;
        }

        /* Mobile specific improvements */
        @media (max-width: 640px) {
            .dashboard-header {
                margin: 0;
                border-radius: 0;
            }
            
            .dashboard-content {
                padding: 0.5rem 0.5rem 2rem 0.5rem;
            }
            
            .collapsible-card {
                margin-bottom: 0.75rem;
                border-radius: 16px;
            }
            
            .card-header {
                padding: 1rem;
            }
            
            .card-content-inner {
                padding: 1rem;
                padding-top: 0;
            }
        }

        /* Custom icons for different sections */
        .icon-qr { background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); }
        .icon-profile { background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%); }
        .icon-social { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
        .icon-gallery { background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); }
        .icon-store { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .icon-templates { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

        /* Quick Action Button Styles */
        /* Clean Form Elements */
        .liquid-input {
            width: 100%;
            padding: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            background: #ffffff;
            color: #374151;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .liquid-input::placeholder {
            color: #9CA3AF;
            font-weight: 400;
        }

        .liquid-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .liquid-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .liquid-input {
                background: rgba(31, 41, 55, 0.8);
                border-color: rgba(75, 85, 99, 0.3);
                color: #F9FAFB;
                box-shadow: 
                    0 1px 3px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .liquid-input::placeholder {
                color: #9CA3AF;
            }

            .liquid-input:focus {
                background: rgba(55, 65, 81, 0.9);
                border-color: rgba(59, 130, 246, 0.6);
                box-shadow: 
                    0 0 0 3px rgba(59, 130, 246, 0.2),
                    0 1px 3px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .liquid-label {
                color: #F9FAFB;
            }
        }

        .qr-code-container {
            text-align: center;
            padding: 2.5rem;
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.95) 0%, 
                rgba(249, 250, 251, 0.85) 35%,
                rgba(249, 250, 251, 0.8) 65%,
                rgba(255, 255, 255, 0.95) 100%);
            backdrop-filter: blur(30px) saturate(180%) brightness(1.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid rgba(255, 255, 255, 0.8);
            border-left: 2px solid rgba(255, 255, 255, 0.6);
            border-radius: 28px;
            margin-bottom: 1.5rem;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.12),
                0 10px 25px rgba(0, 0, 0, 0.08),
                0 4px 12px rgba(0, 0, 0, 0.04),
                inset 0 3px 0 rgba(255, 255, 255, 0.9),
                inset 0 -1px 0 rgba(255, 255, 255, 0.4),
                inset 3px 0 0 rgba(255, 255, 255, 0.3),
                inset -1px 0 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        } 
                rgba(255, 255, 255, 0.15) 0%, 
                rgba(255, 255, 255, 0.08) 100%);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .qr-code-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.7) 0%, 
                rgba(255, 255, 255, 0.3) 40%,
                rgba(255, 255, 255, 0.1) 70%,
                transparent 100%);
            border-radius: 28px 28px 0 0;
            pointer-events: none;
            mix-blend-mode: overlay;
        }

        .qr-code-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 40%;
            height: 30%;
            background: linear-gradient(315deg, 
                rgba(255, 255, 255, 0.25) 0%, 
                rgba(255, 255, 255, 0.1) 50%,
                transparent 100%);
            border-radius: 0 0 28px 0;
            pointer-events: none;
        }

        .qr-code-image {
            width: 10rem;
            height: 10rem;
            border-radius: 24px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.15),
                0 8px 20px rgba(0, 0, 0, 0.1),
                0 0 0 2px rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.6);
            margin: 0 auto 1.5rem;
            background: white;
            padding: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 1.5rem;
        }
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .quick-action-btn:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateY(-1px);
        }

        .notification-btn {
            position: relative;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .notification-btn:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 1.25rem;
            height: 1.25rem;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 50%;
            font-size: 0.625rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.25rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            cursor: pointer;
        }

        .user-menu-btn:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-avatar-large {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu-btn {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .mobile-menu-btn:hover {
            background: rgba(59, 130, 246, 0.15);
        }

        /* Dropdown Menus */
        .notification-dropdown,
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 20rem;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(20px);
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s ease;
        }

        .notification-dropdown.show,
        .user-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: between;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .notification-header h3 {
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }

        .notification-item:hover {
            background: #f9fafb;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-title {
            font-weight: 500;
            color: #111827;
            font-size: 0.875rem;
        }

        .notification-time {
            color: #6b7280;
            font-size: 0.75rem;
        }

        .user-dropdown-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .user-dropdown-section {
            padding: 0.5rem 0;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .user-dropdown-item:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .user-dropdown-item i {
            width: 1rem;
            text-align: center;
        }

        /* Mobile Navigation */
        .mobile-nav-menu {
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 12px;
            margin-top: 0.75rem;
        }

        .mobile-nav-menu.show {
            max-height: 500px;
        }

        .mobile-nav-section {
            padding: 0.75rem;
        }

        .mobile-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 8px;
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }

        .mobile-nav-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .mobile-nav-item.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
        }

        .mobile-nav-item:last-child {
            margin-bottom: 0;
        }

        /* Unified Menu System */
        .unified-menu-btn {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .unified-menu-btn:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .menu-lines {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .menu-lines span {
            width: 18px;
            height: 2px;
            background: #3b82f6;
            border-radius: 1px;
            transition: all 0.3s ease;
        }

        .unified-menu-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            width: 22rem;
            max-width: calc(100vw - 2rem);
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            max-height: 80vh;
            overflow-y: auto;
        }

        .unified-menu-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .menu-user-section {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .menu-section {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .menu-section:last-child {
            border-bottom: none;
        }

        .menu-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notification-count {
            background: #ef4444;
            color: white;
            border-radius: 10px;
            padding: 0.125rem 0.5rem;
            font-size: 0.625rem;
            font-weight: 700;
        }

        .menu-nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0.75rem;
            border-radius: 8px;
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 0.25rem;
            transition: all 0.2s;
        }

        .menu-nav-item:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .menu-nav-item.active {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            color: white;
        }

        .menu-nav-item:last-child {
            margin-bottom: 0;
        }

        .menu-nav-item i {
            width: 1rem;
            text-align: center;
        }

        .menu-action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
        }

        .menu-action-btn:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateY(-1px);
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .unified-menu-dropdown {
                width: calc(100vw - 1rem);
                right: -0.5rem;
            }
        }
        /* Additional Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .quick-action-btn {
                background: rgba(59, 130, 246, 0.15);
                border-color: rgba(59, 130, 246, 0.3);
                color: #60a5fa;
            }

            .quick-action-btn:hover {
                background: rgba(59, 130, 246, 0.25);
                border-color: rgba(59, 130, 246, 0.4);
            }

            .notification-btn {
                background: rgba(59, 130, 246, 0.15);
                border-color: rgba(59, 130, 246, 0.3);
                color: #60a5fa;
            }

            .notification-dot {
                background: #f97316;
            }

            .qr-code-container {
                background: rgba(31, 41, 55, 0.8);
                border-color: rgba(75, 85, 99, 0.3);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.5),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .section-header h3,
            .section-title {
                color: #F9FAFB;
            }

            .section-header .toggle-btn {
                color: #F9FAFB;
                background: rgba(31, 41, 55, 0.5);
                border-color: rgba(75, 85, 99, 0.3);
            }

            .section-header .toggle-btn:hover {
                background: rgba(55, 65, 81, 0.7);
                color: #FFFFFF;
            }

            .hamburger-menu {
                background: rgba(31, 41, 55, 0.9);
                border-color: rgba(75, 85, 99, 0.3);
                box-shadow: 
                    0 8px 25px rgba(0, 0, 0, 0.5),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .hamburger-line {
                background-color: #F9FAFB;
            }

            .menu-overlay {
                background: rgba(0, 0, 0, 0.8);
            }

            .menu-content {
                background: rgba(31, 41, 55, 0.95);
                border-color: rgba(75, 85, 99, 0.3);
                box-shadow: 
                    0 20px 50px rgba(0, 0, 0, 0.7),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .menu-item {
                color: #F9FAFB;
                border-bottom-color: rgba(75, 85, 99, 0.3);
            }

            .menu-item:hover {
                background: rgba(55, 65, 81, 0.5);
                color: #FFFFFF;
            }

            .glass-card {
                background: rgba(31, 41, 55, 0.8);
                border-color: rgba(75, 85, 99, 0.3);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.5),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }

            .glass-card h3, 
            .glass-card .stat-value {
                color: #F9FAFB;
            }

            .glass-card p, 
            .glass-card .text-gray-600,
            .glass-card .stat-label {
                color: #D1D5DB !important;
            }
        }

        /* Realistic Glass Overlay Effects */
        .qr-code-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(145deg, 
                rgba(255, 255, 255, 0.7) 0%, 
                rgba(255, 255, 255, 0.3) 40%,
                rgba(255, 255, 255, 0.1) 70%,
                transparent 100%);
            border-radius: 28px 28px 0 0;
            pointer-events: none;
            mix-blend-mode: overlay;
        }

        .qr-code-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 40%;
            height: 30%;
            background: linear-gradient(315deg, 
                rgba(255, 255, 255, 0.25) 0%, 
                rgba(255, 255, 255, 0.1) 50%,
                transparent 100%);
            border-radius: 0 0 28px 0;
            pointer-events: none;
        }
    </style>

    <div class="dashboard-container">
        <!-- Enhanced Navigation Header -->
        <nav class="dashboard-header">
            <div class="dashboard-content">
                <div class="flex items-center justify-between py-4">
                    <!-- Left Side - Logo Only -->
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <i class="fas fa-qrcode text-white text-lg"></i>
                        </div>
                        <div class="hidden sm:block">
                            <div class="text-lg font-bold text-gray-900">Smart Tag</div>
                            <div class="text-xs text-gray-500">Digital Business Card</div>
                        </div>
                    </div>

                    <!-- Right Side - Unified Menu -->
                    <div class="flex items-center space-x-3">
                        <!-- Quick Actions - Desktop Only -->
                        <div class="hidden lg:flex items-center space-x-2">
                            @if($qrCode)
                            <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="quick-action-btn">
                                <i class="fas fa-external-link-alt text-sm"></i>
                                <span>View Card</span>
                            </a>
                            @endif
                            <button class="quick-action-btn" onclick="window.print()">
                                <i class="fas fa-print text-sm"></i>
                                <span>Print QR</span>
                            </button>
                        </div>

                        <!-- Unified Menu Button -->
                        <div class="relative">
                            <button class="unified-menu-btn" onclick="toggleUnifiedMenu()">
                                <div class="menu-lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </button>

                            <!-- Unified Dropdown Menu -->
                            <div id="unified-menu-dropdown" class="unified-menu-dropdown">
                                <!-- User Section -->
                                <div class="menu-user-section">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <div class="user-avatar-large">
                                            @if($profile && $profile->profile_image_url)
                                                <img src="{{ $profile->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fas fa-user text-white"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-900">{{ auth()->user()->name }}</div>
                                            <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                                            <div class="text-xs text-blue-600 font-medium">
                                                @if(auth()->user()->isOnTrial())
                                                    Trial expires {{ auth()->user()->trial_ends_at->format('M d') }}
                                                @else
                                                    Premium until {{ auth()->user()->subscription_ends_at->format('M d') }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions - Mobile -->
                                <div class="menu-section lg:hidden">
                                    <div class="menu-section-title">Quick Actions</div>
                                    <div class="grid grid-cols-2 gap-2 mb-4">
                                        @if($qrCode)
                                        <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="menu-action-btn">
                                            <i class="fas fa-external-link-alt"></i>
                                            <span>View Card</span>
                                        </a>
                                        @endif
                                        <button class="menu-action-btn" onclick="window.print()">
                                            <i class="fas fa-print"></i>
                                            <span>Print QR</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Navigation -->
                                <div class="menu-section">
                                    <div class="menu-section-title">Navigation</div>
                                    <a href="{{ route('dashboard') }}" class="menu-nav-item active">
                                        <i class="fas fa-home"></i>
                                        <span>Dashboard</span>
                                    </a>
                                    @if($profile && $profile->store_enabled)
                                    <a href="{{ route('dashboard.store') }}" class="menu-nav-item">
                                        <i class="fas fa-store"></i>
                                        <span>My Store</span>
                                    </a>
                                    @endif
                                    <a href="{{ route('plans') }}" class="menu-nav-item">
                                        <i class="fas fa-crown"></i>
                                        <span>Upgrade Plan</span>
                                    </a>
                                </div>

                                <!-- Notifications -->
                                <div class="menu-section">
                                    <div class="menu-section-title">
                                        Notifications
                                        <span class="notification-count">2</span>
                                    </div>
                                    <div class="notification-item">
                                        <div class="notification-icon bg-blue-100 text-blue-600">
                                            <i class="fas fa-user-plus text-xs"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="notification-title">New contact scanned</div>
                                            <div class="notification-time">2 minutes ago</div>
                                        </div>
                                    </div>
                                    <div class="notification-item">
                                        <div class="notification-icon bg-green-100 text-green-600">
                                            <i class="fas fa-chart-line text-xs"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="notification-title">Weekly report ready</div>
                                            <div class="notification-time">1 hour ago</div>
                                        </div>
                                    </div>
                                    <button class="text-blue-600 text-sm font-medium mt-2">Mark all read</button>
                                </div>

                                <!-- Settings -->
                                <div class="menu-section">
                                    <div class="menu-section-title">Account</div>
                                    <a href="{{ route('profile.edit') }}" class="menu-nav-item">
                                        <i class="fas fa-user-cog"></i>
                                        <span>Account Settings</span>
                                    </a>
                                    <a href="#" onclick="document.getElementById('logout-form').submit(); return false;" class="menu-nav-item text-red-600">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Sign Out</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>

        <div class="dashboard-content">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="notification-banner" style="background: linear-gradient(135deg, rgba(209, 250, 229, 0.95) 0%, rgba(167, 243, 208, 0.9) 100%); border: 1px solid rgba(110, 231, 183, 0.3); color: #065f46; backdrop-filter: blur(20px); border-radius: 16px; padding: 16px 20px; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 32px; height: 32px; background: rgba(16, 185, 129, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle" style="color: #059669;"></i>
                        </div>
                        <span style="font-weight: 500;">{{ session('success') }}</span>
                        <button onclick="this.parentElement.parentElement.remove()" style="margin-left: auto; background: none; border: none; color: #059669; cursor: pointer; font-size: 18px;">&times;</button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="notification-banner" style="background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%); border-color: #f87171; color: #991b1b;">
                    <span><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="notification-banner" style="background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%); border-color: #f87171; color: #991b1b;">
                    <div>
                        @foreach ($errors->all() as $error)
                            <div><i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($profile && $profile->latest_inapp_message)
                <div id="inapp-message-banner" class="notification-banner">
                    <span>{{ $profile->latest_inapp_message }}</span>
                    <button onclick="dismissInAppMessage()" class="text-blue-600 hover:text-blue-800 font-bold text-lg ml-2">&times;</button>
                </div>
            @endif

            <!-- Trial/Subscription Status -->
            <div style="background: linear-gradient(135deg, rgba(232, 245, 232, 0.95) 0%, rgba(200, 230, 201, 0.9) 100%); border: 1px solid rgba(76, 175, 80, 0.2); border-radius: 16px; padding: 16px 20px; margin-bottom: 20px; backdrop-filter: blur(20px); box-shadow: 0 4px 12px rgba(76, 175, 80, 0.1);">
                @if(auth()->user()->isOnTrial())
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 24px; height: 24px; background: rgba(255, 193, 7, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock" style="color: #ff9800; font-size: 12px;"></i>
                        </div>
                        <span style="font-weight: 600; color: #2e7d32;">Trial:</span>
                        <span style="color: #388e3c;">Expires {{ auth()->user()->trial_ends_at->format('M d, Y') }}</span>
                        <a href="{{ route('plans') }}" style="margin-left: auto; background: #4caf50; color: white; padding: 6px 16px; border-radius: 20px; text-decoration: none; font-weight: 500; font-size: 14px;">Upgrade</a>
                    </div>
                @elseif(auth()->user()->hasActiveSubscription())
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 24px; height: 24px; background: rgba(76, 175, 80, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle" style="color: #4caf50; font-size: 12px;"></i>
                        </div>
                        <span style="font-weight: 600; color: #6b7280;">Active:</span>
                        <span style="color: #6b7280;">{{ $subscription->plan_name ?? 'Premium' }} until {{ auth()->user()->subscription_ends_at->format('M d, Y') }}</span>
                    </div>
                @endif
            </div>

            <!-- QR Code Card -->
            @if($qrCode)
            <div class="collapsible-card" style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.9) 100%); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); border-radius: 20px;">
                <div class="card-header" onclick="toggleCard('qr-card')" style="padding-bottom: 3rem; min-height: 80px;">
                    <div class="card-title">
                        <div class="card-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: #007AFF; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(0, 122, 255, 0.3);">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 600; color: #1f2937;">My QR Code</div>
                        </div>
                    </div>
                    <div style="position: absolute; bottom: 16px; right: 60px;">
                        <div style="background: rgba(16, 185, 129, 0.15); color: #059669; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(16, 185, 129, 0.2);">{{ $qrCode->scan_count }} scans</div>
                    </div>
                    <div class="expand-icon" id="qr-card-icon" style="position: absolute; bottom: 16px; right: 16px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-chevron-down" style="color: #6b7280;"></i>
                    </div>
                </div>
                <div class="card-content expanded" id="qr-card-content">
                    <div class="card-content-inner">
                        <div class="qr-code-container">
                            <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="qr-code-image">
                            <div class="text-sm mb-3" style="color: #374151 !important;">Scan to view your profile</div>
                            
                            <div class="quick-actions">
                                <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="action-btn btn-primary">
                                    <i class="fas fa-external-link-alt"></i> View
                                </a>
                                <a href="{{ route('qr.download', $qrCode->uuid) }}" class="action-btn btn-secondary" title="Download high-quality PNG (500x500)">
                                    <i class="fas fa-file-image"></i> PNG
                                </a>
                                <a href="{{ route('qr.download.svg', $qrCode->uuid) }}" class="action-btn btn-success" title="Download vector SVG (perfect for printing)">
                                    <i class="fas fa-vector-square"></i> SVG
                                </a>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm" style="color: #374151 !important;">
                            <div class="flex justify-between"><span>Code:</span> <span class="font-mono">{{ $qrCode->code }}</span></div>
                            <div class="flex justify-between"><span>Claimed:</span> <span>{{ $qrCode->claimed_at->format('M d, Y') }}</span></div>
                            <div class="flex justify-between"><span>Last Scan:</span> <span>@if($qrCode->last_scanned_at){{ $qrCode->last_scanned_at->diffForHumans() }}@else Never @endif</span></div>
                        </div>

                        @if($profile && $profile->store_enabled)
                            <div class="mt-4">
                                <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="action-btn btn-success w-full">
                                    <i class="fas fa-store"></i> View Store
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- vCard Templates Card -->
            <div class="collapsible-card">
                <div class="card-header" onclick="toggleCard('templates-card')" style="padding-bottom: 3rem; min-height: 80px;">
                    <div class="card-title">
                        <div class="card-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: #FF9500; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(255, 149, 0, 0.3);">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div style="font-size: 16px; font-weight: 600; color: #1f2937;">vCard Templates</div>
                    </div>
                    <div class="expand-icon" id="templates-card-icon" style="position: absolute; bottom: 16px; right: 16px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-chevron-down" style="color: #6b7280;"></i>
                    </div>
                </div>
                <div class="card-content" id="templates-card-content">
                    <div class="card-content-inner">
                        <a href="{{ route('dashboard.vcard-templates') }}" class="action-btn btn-primary w-full">
                            <i class="fas fa-id-card"></i> Choose Template
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="collapsible-card">
                <div class="card-header" onclick="toggleCard('profile-card')" style="padding-bottom: 3rem; min-height: 80px;">
                    <div class="card-title">
                        <div class="card-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: #AF52DE; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(175, 82, 222, 0.3);">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div style="font-size: 16px; font-weight: 600; color: #1f2937;">Profile Information</div>
                    </div>
                    <div class="expand-icon" id="profile-card-icon" style="position: absolute; bottom: 16px; right: 16px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-chevron-down" style="color: #6b7280;"></i>
                    </div>
                </div>
                <div class="card-content" id="profile-card-content">
                    <div class="card-content-inner">
                        <!-- Profile photo section -->
                        <div class="text-center mb-6">
                            @if($profile && $profile->profile_image)
                                <div class="relative inline-block">
                                    <img src="{{ $profile->profile_image_url }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg mx-auto">
                                    <button type="button" onclick="removeProfileImage()" class="absolute -top-1 -right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center mx-auto">
                                    <i class="fas fa-user text-2xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Forms -->
                        @if($profile && $profile->profile_image)
                            <form id="remove-profile-form" action="{{ route('dashboard.profile.remove-image') }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                        @if($profile && $profile->background_image)
                            <form id="remove-background-form" action="{{ route('dashboard.profile.remove-background') }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif

                        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="liquid-label">Profile Photo</label>
                                <input type="file" name="profile_image" accept="image/jpeg,image/png,image/jpg,image/gif" class="liquid-input">
                            </div>

                            <div>
                                <label class="liquid-label">Name</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" class="liquid-input" required>
                            </div>
                            
                            <div>
                                <label class="liquid-label">Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}" class="liquid-input" required>
                            </div>
                            
                            <div>
                                <label class="liquid-label">Display Name</label>
                                <input type="text" name="display_name" value="{{ $profile->display_name ?? '' }}" class="liquid-input">
                            </div>
                            
                            <div>
                                <label class="liquid-label">Phone</label>
                                <input type="text" name="phone" value="{{ $profile->phone ?? '' }}" class="liquid-input">
                            </div>
                            
                            <div>
                                <label class="liquid-label">District</label>
                                <select name="location" class="liquid-input">
                                    <option value="">Select your district</option>
                                    <option value="Abim" {{ ($profile->location ?? '') == 'Abim' ? 'selected' : '' }}>Abim</option>
                                    <option value="Adjumani" {{ ($profile->location ?? '') == 'Adjumani' ? 'selected' : '' }}>Adjumani</option>
                                    <option value="Agago" {{ ($profile->location ?? '') == 'Agago' ? 'selected' : '' }}>Agago</option>
                                    <option value="Alebtong" {{ ($profile->location ?? '') == 'Alebtong' ? 'selected' : '' }}>Alebtong</option>
                                    <option value="Amolatar" {{ ($profile->location ?? '') == 'Amolatar' ? 'selected' : '' }}>Amolatar</option>
                                    <option value="Amudat" {{ ($profile->location ?? '') == 'Amudat' ? 'selected' : '' }}>Amudat</option>
                                    <option value="Amuria" {{ ($profile->location ?? '') == 'Amuria' ? 'selected' : '' }}>Amuria</option>
                                    <option value="Amuru" {{ ($profile->location ?? '') == 'Amuru' ? 'selected' : '' }}>Amuru</option>
                                    <option value="Apac" {{ ($profile->location ?? '') == 'Apac' ? 'selected' : '' }}>Apac</option>
                                    <option value="Arua" {{ ($profile->location ?? '') == 'Arua' ? 'selected' : '' }}>Arua</option>
                                    <option value="Budaka" {{ ($profile->location ?? '') == 'Budaka' ? 'selected' : '' }}>Budaka</option>
                                    <option value="Bududa" {{ ($profile->location ?? '') == 'Bududa' ? 'selected' : '' }}>Bududa</option>
                                    <option value="Bugiri" {{ ($profile->location ?? '') == 'Bugiri' ? 'selected' : '' }}>Bugiri</option>
                                    <option value="Buikwe" {{ ($profile->location ?? '') == 'Buikwe' ? 'selected' : '' }}>Buikwe</option>
                                    <option value="Bukedea" {{ ($profile->location ?? '') == 'Bukedea' ? 'selected' : '' }}>Bukedea</option>
                                    <option value="Bukomansimbi" {{ ($profile->location ?? '') == 'Bukomansimbi' ? 'selected' : '' }}>Bukomansimbi</option>
                                    <option value="Bukwo" {{ ($profile->location ?? '') == 'Bukwo' ? 'selected' : '' }}>Bukwo</option>
                                    <option value="Bulambuli" {{ ($profile->location ?? '') == 'Bulambuli' ? 'selected' : '' }}>Bulambuli</option>
                                    <option value="Buliisa" {{ ($profile->location ?? '') == 'Buliisa' ? 'selected' : '' }}>Buliisa</option>
                                    <option value="Bundibugyo" {{ ($profile->location ?? '') == 'Bundibugyo' ? 'selected' : '' }}>Bundibugyo</option>
                                    <option value="Bushenyi" {{ ($profile->location ?? '') == 'Bushenyi' ? 'selected' : '' }}>Bushenyi</option>
                                    <option value="Busia" {{ ($profile->location ?? '') == 'Busia' ? 'selected' : '' }}>Busia</option>
                                    <option value="Butaleja" {{ ($profile->location ?? '') == 'Butaleja' ? 'selected' : '' }}>Butaleja</option>
                                    <option value="Butambala" {{ ($profile->location ?? '') == 'Butambala' ? 'selected' : '' }}>Butambala</option>
                                    <option value="Buvuma" {{ ($profile->location ?? '') == 'Buvuma' ? 'selected' : '' }}>Buvuma</option>
                                    <option value="Buyende" {{ ($profile->location ?? '') == 'Buyende' ? 'selected' : '' }}>Buyende</option>
                                    <option value="Dokolo" {{ ($profile->location ?? '') == 'Dokolo' ? 'selected' : '' }}>Dokolo</option>
                                    <option value="Gomba" {{ ($profile->location ?? '') == 'Gomba' ? 'selected' : '' }}>Gomba</option>
                                    <option value="Gulu" {{ ($profile->location ?? '') == 'Gulu' ? 'selected' : '' }}>Gulu</option>
                                    <option value="Hoima" {{ ($profile->location ?? '') == 'Hoima' ? 'selected' : '' }}>Hoima</option>
                                    <option value="Ibanda" {{ ($profile->location ?? '') == 'Ibanda' ? 'selected' : '' }}>Ibanda</option>
                                    <option value="Iganga" {{ ($profile->location ?? '') == 'Iganga' ? 'selected' : '' }}>Iganga</option>
                                    <option value="Isingiro" {{ ($profile->location ?? '') == 'Isingiro' ? 'selected' : '' }}>Isingiro</option>
                                    <option value="Jinja" {{ ($profile->location ?? '') == 'Jinja' ? 'selected' : '' }}>Jinja</option>
                                    <option value="Kaabong" {{ ($profile->location ?? '') == 'Kaabong' ? 'selected' : '' }}>Kaabong</option>
                                    <option value="Kabale" {{ ($profile->location ?? '') == 'Kabale' ? 'selected' : '' }}>Kabale</option>
                                    <option value="Kabarole" {{ ($profile->location ?? '') == 'Kabarole' ? 'selected' : '' }}>Kabarole</option>
                                    <option value="Kaberamaido" {{ ($profile->location ?? '') == 'Kaberamaido' ? 'selected' : '' }}>Kaberamaido</option>
                                    <option value="Kalangala" {{ ($profile->location ?? '') == 'Kalangala' ? 'selected' : '' }}>Kalangala</option>
                                    <option value="Kaliro" {{ ($profile->location ?? '') == 'Kaliro' ? 'selected' : '' }}>Kaliro</option>
                                    <option value="Kalungu" {{ ($profile->location ?? '') == 'Kalungu' ? 'selected' : '' }}>Kalungu</option>
                                    <option value="Kampala" {{ ($profile->location ?? '') == 'Kampala' ? 'selected' : '' }}>Kampala</option>
                                    <option value="Kamuli" {{ ($profile->location ?? '') == 'Kamuli' ? 'selected' : '' }}>Kamuli</option>
                                    <option value="Kamwenge" {{ ($profile->location ?? '') == 'Kamwenge' ? 'selected' : '' }}>Kamwenge</option>
                                    <option value="Kanungu" {{ ($profile->location ?? '') == 'Kanungu' ? 'selected' : '' }}>Kanungu</option>
                                    <option value="Kapchorwa" {{ ($profile->location ?? '') == 'Kapchorwa' ? 'selected' : '' }}>Kapchorwa</option>
                                    <option value="Kasese" {{ ($profile->location ?? '') == 'Kasese' ? 'selected' : '' }}>Kasese</option>
                                    <option value="Katakwi" {{ ($profile->location ?? '') == 'Katakwi' ? 'selected' : '' }}>Katakwi</option>
                                    <option value="Kayunga" {{ ($profile->location ?? '') == 'Kayunga' ? 'selected' : '' }}>Kayunga</option>
                                    <option value="Kibaale" {{ ($profile->location ?? '') == 'Kibaale' ? 'selected' : '' }}>Kibaale</option>
                                    <option value="Kiboga" {{ ($profile->location ?? '') == 'Kiboga' ? 'selected' : '' }}>Kiboga</option>
                                    <option value="Kibuku" {{ ($profile->location ?? '') == 'Kibuku' ? 'selected' : '' }}>Kibuku</option>
                                    <option value="Kiruhura" {{ ($profile->location ?? '') == 'Kiruhura' ? 'selected' : '' }}>Kiruhura</option>
                                    <option value="Kiryandongo" {{ ($profile->location ?? '') == 'Kiryandongo' ? 'selected' : '' }}>Kiryandongo</option>
                                    <option value="Kisoro" {{ ($profile->location ?? '') == 'Kisoro' ? 'selected' : '' }}>Kisoro</option>
                                    <option value="Kitgum" {{ ($profile->location ?? '') == 'Kitgum' ? 'selected' : '' }}>Kitgum</option>
                                    <option value="Koboko" {{ ($profile->location ?? '') == 'Koboko' ? 'selected' : '' }}>Koboko</option>
                                    <option value="Kole" {{ ($profile->location ?? '') == 'Kole' ? 'selected' : '' }}>Kole</option>
                                    <option value="Kotido" {{ ($profile->location ?? '') == 'Kotido' ? 'selected' : '' }}>Kotido</option>
                                    <option value="Kumi" {{ ($profile->location ?? '') == 'Kumi' ? 'selected' : '' }}>Kumi</option>
                                    <option value="Kween" {{ ($profile->location ?? '') == 'Kween' ? 'selected' : '' }}>Kween</option>
                                    <option value="Kyankwanzi" {{ ($profile->location ?? '') == 'Kyankwanzi' ? 'selected' : '' }}>Kyankwanzi</option>
                                    <option value="Kyegegwa" {{ ($profile->location ?? '') == 'Kyegegwa' ? 'selected' : '' }}>Kyegegwa</option>
                                    <option value="Kyenjojo" {{ ($profile->location ?? '') == 'Kyenjojo' ? 'selected' : '' }}>Kyenjojo</option>
                                    <option value="Lamwo" {{ ($profile->location ?? '') == 'Lamwo' ? 'selected' : '' }}>Lamwo</option>
                                    <option value="Lira" {{ ($profile->location ?? '') == 'Lira' ? 'selected' : '' }}>Lira</option>
                                    <option value="Luuka" {{ ($profile->location ?? '') == 'Luuka' ? 'selected' : '' }}>Luuka</option>
                                    <option value="Luwero" {{ ($profile->location ?? '') == 'Luwero' ? 'selected' : '' }}>Luwero</option>
                                    <option value="Lwengo" {{ ($profile->location ?? '') == 'Lwengo' ? 'selected' : '' }}>Lwengo</option>
                                    <option value="Lyantonde" {{ ($profile->location ?? '') == 'Lyantonde' ? 'selected' : '' }}>Lyantonde</option>
                                    <option value="Manafwa" {{ ($profile->location ?? '') == 'Manafwa' ? 'selected' : '' }}>Manafwa</option>
                                    <option value="Maracha" {{ ($profile->location ?? '') == 'Maracha' ? 'selected' : '' }}>Maracha</option>
                                    <option value="Masaka" {{ ($profile->location ?? '') == 'Masaka' ? 'selected' : '' }}>Masaka</option>
                                    <option value="Masindi" {{ ($profile->location ?? '') == 'Masindi' ? 'selected' : '' }}>Masindi</option>
                                    <option value="Mayuge" {{ ($profile->location ?? '') == 'Mayuge' ? 'selected' : '' }}>Mayuge</option>
                                    <option value="Mbale" {{ ($profile->location ?? '') == 'Mbale' ? 'selected' : '' }}>Mbale</option>
                                    <option value="Mbarara" {{ ($profile->location ?? '') == 'Mbarara' ? 'selected' : '' }}>Mbarara</option>
                                    <option value="Mitooma" {{ ($profile->location ?? '') == 'Mitooma' ? 'selected' : '' }}>Mitooma</option>
                                    <option value="Mityana" {{ ($profile->location ?? '') == 'Mityana' ? 'selected' : '' }}>Mityana</option>
                                    <option value="Moroto" {{ ($profile->location ?? '') == 'Moroto' ? 'selected' : '' }}>Moroto</option>
                                    <option value="Moyo" {{ ($profile->location ?? '') == 'Moyo' ? 'selected' : '' }}>Moyo</option>
                                    <option value="Mpigi" {{ ($profile->location ?? '') == 'Mpigi' ? 'selected' : '' }}>Mpigi</option>
                                    <option value="Mubende" {{ ($profile->location ?? '') == 'Mubende' ? 'selected' : '' }}>Mubende</option>
                                    <option value="Mukono" {{ ($profile->location ?? '') == 'Mukono' ? 'selected' : '' }}>Mukono</option>
                                    <option value="Nakapiripirit" {{ ($profile->location ?? '') == 'Nakapiripirit' ? 'selected' : '' }}>Nakapiripirit</option>
                                    <option value="Nakaseke" {{ ($profile->location ?? '') == 'Nakaseke' ? 'selected' : '' }}>Nakaseke</option>
                                    <option value="Nakasongola" {{ ($profile->location ?? '') == 'Nakasongola' ? 'selected' : '' }}>Nakasongola</option>
                                    <option value="Namayingo" {{ ($profile->location ?? '') == 'Namayingo' ? 'selected' : '' }}>Namayingo</option>
                                    <option value="Namutumba" {{ ($profile->location ?? '') == 'Namutumba' ? 'selected' : '' }}>Namutumba</option>
                                    <option value="Napak" {{ ($profile->location ?? '') == 'Napak' ? 'selected' : '' }}>Napak</option>
                                    <option value="Nebbi" {{ ($profile->location ?? '') == 'Nebbi' ? 'selected' : '' }}>Nebbi</option>
                                    <option value="Ngora" {{ ($profile->location ?? '') == 'Ngora' ? 'selected' : '' }}>Ngora</option>
                                    <option value="Ntoroko" {{ ($profile->location ?? '') == 'Ntoroko' ? 'selected' : '' }}>Ntoroko</option>
                                    <option value="Ntungamo" {{ ($profile->location ?? '') == 'Ntungamo' ? 'selected' : '' }}>Ntungamo</option>
                                    <option value="Nwoya" {{ ($profile->location ?? '') == 'Nwoya' ? 'selected' : '' }}>Nwoya</option>
                                    <option value="Otuke" {{ ($profile->location ?? '') == 'Otuke' ? 'selected' : '' }}>Otuke</option>
                                    <option value="Oyam" {{ ($profile->location ?? '') == 'Oyam' ? 'selected' : '' }}>Oyam</option>
                                    <option value="Pader" {{ ($profile->location ?? '') == 'Pader' ? 'selected' : '' }}>Pader</option>
                                    <option value="Pallisa" {{ ($profile->location ?? '') == 'Pallisa' ? 'selected' : '' }}>Pallisa</option>
                                    <option value="Rakai" {{ ($profile->location ?? '') == 'Rakai' ? 'selected' : '' }}>Rakai</option>
                                    <option value="Rubirizi" {{ ($profile->location ?? '') == 'Rubirizi' ? 'selected' : '' }}>Rubirizi</option>
                                    <option value="Rukungiri" {{ ($profile->location ?? '') == 'Rukungiri' ? 'selected' : '' }}>Rukungiri</option>
                                    <option value="Sembabule" {{ ($profile->location ?? '') == 'Sembabule' ? 'selected' : '' }}>Sembabule</option>
                                    <option value="Serere" {{ ($profile->location ?? '') == 'Serere' ? 'selected' : '' }}>Serere</option>
                                    <option value="Sheema" {{ ($profile->location ?? '') == 'Sheema' ? 'selected' : '' }}>Sheema</option>
                                    <option value="Sironko" {{ ($profile->location ?? '') == 'Sironko' ? 'selected' : '' }}>Sironko</option>
                                    <option value="Soroti" {{ ($profile->location ?? '') == 'Soroti' ? 'selected' : '' }}>Soroti</option>
                                    <option value="Tororo" {{ ($profile->location ?? '') == 'Tororo' ? 'selected' : '' }}>Tororo</option>
                                    <option value="Wakiso" {{ ($profile->location ?? '') == 'Wakiso' ? 'selected' : '' }}>Wakiso</option>
                                    <option value="Yumbe" {{ ($profile->location ?? '') == 'Yumbe' ? 'selected' : '' }}>Yumbe</option>
                                    <option value="Zombo" {{ ($profile->location ?? '') == 'Zombo' ? 'selected' : '' }}>Zombo</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="liquid-label">Bio</label>
                                <textarea name="bio" rows="3" class="liquid-input" placeholder="Tell us about yourself...">{{ $profile->bio ?? '' }}</textarea>
                            </div>
                            
                            <button type="submit" class="liquid-btn w-full py-3">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Social Links Card -->
            <div class="collapsible-card">
                <div class="card-header" onclick="toggleCard('social-card')" style="padding-bottom: 3rem; min-height: 80px;">
                    <div class="card-title">
                        <div class="card-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: #32D74B; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(50, 215, 75, 0.3);">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 600; color: #1f2937;">Social Links</div>
                        </div>
                    </div>
                    <div style="position: absolute; bottom: 16px; right: 60px;">
                        <div class="card-status" style="background: rgba(50, 215, 75, 0.15); color: #059669; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(50, 215, 75, 0.2); box-shadow: 0 2px 8px rgba(50, 215, 75, 0.1);">{{ $socialLinks->count() }} links</div>
                    </div>
                    <div class="expand-icon" id="social-card-icon" style="position: absolute; bottom: 16px; right: 16px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-chevron-down" style="color: #6b7280;"></i>
                    </div>
                </div>
                <div class="card-content" id="social-card-content">
                    <div class="card-content-inner">
                        <form action="{{ route('dashboard.social-links.add') }}" method="POST" class="space-y-4 mb-4">
                            @csrf
                            <div>
                                <label class="liquid-label">Platform</label>
                                <select name="platform" class="liquid-input" required>
                                    <option value="">Select Platform</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="tiktok">TikTok</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="website">Website</option>
                                </select>
                            </div>
                            <div>
                                <label class="liquid-label">URL</label>
                                <input type="url" name="url" placeholder="https://..." class="liquid-input" required>
                            </div>
                            <button type="submit" class="liquid-btn w-full">
                                <i class="fas fa-plus"></i> Add Link
                            </button>
                        </form>

                        @if($socialLinks->count() > 0)
                            <div class="space-y-3">
                                @foreach($socialLinks as $link)
                                    <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-3">
                                        <div class="flex items-center space-x-3">
                                            <i class="{{ $link->platform_icon }} text-lg" style="color: 
                                                @if($link->platform === 'facebook') #1877f2
                                                @elseif($link->platform === 'twitter') #1da1f2
                                                @elseif($link->platform === 'instagram') #e4405f
                                                @elseif($link->platform === 'linkedin') #0a66c2
                                                @elseif($link->platform === 'youtube') #ff0000
                                                @elseif($link->platform === 'tiktok') #000000
                                                @elseif($link->platform === 'whatsapp') #25d366
                                                @else #3b82f6 @endif"></i>
                                            <div>
                                                <div class="font-semibold text-sm">{{ ucfirst($link->platform) }}</div>
                                                <a href="{{ $link->formatted_url }}" target="_blank" rel="noopener noreferrer" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1">
                                                    <span>View link</span>
                                                    <i class="fas fa-external-link-alt" style="font-size: 10px;"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <form action="{{ route('dashboard.social-links.delete', $link) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 p-2 rounded-lg hover:bg-red-50 transition-colors" onclick="return confirm('Delete this link?')">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-link text-2xl mb-2"></i>
                                <p class="text-sm">No social links added yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Photo Gallery Card -->
            <div class="collapsible-card">
                <div class="card-header" onclick="toggleCard('gallery-card')" style="padding-bottom: 3rem; min-height: 80px;">
                    <div class="card-title">
                        <div class="card-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: #FF2D92; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(255, 45, 146, 0.3);">
                            <i class="fas fa-images"></i>
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 600; color: #1f2937;">Photo Gallery</div>
                        </div>
                    </div>
                    <div style="position: absolute; bottom: 16px; right: 60px;">
                        <div class="card-status" style="background: rgba(255, 45, 146, 0.15); color: #e91e63; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(255, 45, 146, 0.2); box-shadow: 0 2px 8px rgba(255, 45, 146, 0.1);">{{ $galleryItems->count() }} photos</div>
                    </div>
                    <div class="expand-icon" id="gallery-card-icon" style="position: absolute; bottom: 16px; right: 16px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-chevron-down" style="color: #6b7280;"></i>
                    </div>
                </div>
                <div class="card-content" id="gallery-card-content">
                    <div class="card-content-inner">
                        <!-- Upload Form -->
                        <form id="gallery-upload-form" action="{{ route('dashboard.gallery.add') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mb-6">
                            @csrf
                            <div>
                                <label class="liquid-label">Upload Photo</label>
                                <input type="file" name="image" id="gallery-image" accept="image/jpeg,image/png,image/jpg,image/gif" class="liquid-input" required>
                                <div class="text-xs text-gray-500 mt-1">Max file size: 10MB. Formats: JPG, PNG, GIF</div>
                            </div>
                            <div>
                                <label class="liquid-label">Photo Title (Optional)</label>
                                <input type="text" name="title" placeholder="e.g., My Best Work" class="liquid-input">
                            </div>
                            <button type="submit" class="liquid-btn w-full" id="upload-btn">
                                <i class="fas fa-upload"></i> <span id="btn-text">Upload Photo</span>
                            </button>
                        </form>

                        <!-- Gallery Grid -->
                        @if($galleryItems->count() > 0)
                            <div class="gallery-grid">
                                @foreach($galleryItems as $item)
                                    <div class="gallery-item group">
                                        <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <form action="{{ route('dashboard.gallery.delete', $item) }}" method="POST" onsubmit="return confirm('Delete this photo?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                        @if($item->title)
                                            <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-75 text-white text-xs p-2">
                                                {{ $item->title }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-camera text-2xl mb-2"></i>
                                <p class="text-sm">No photos uploaded yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Store Settings Card -->
            <div class="collapsible-card">
                <div class="card-header" onclick="toggleCard('store-card')" style="padding-bottom: 3rem; min-height: 80px;">
                    <div class="card-title">
                        <div class="card-icon" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: #32D74B; color: white; font-size: 20px; box-shadow: 0 4px 12px rgba(50, 215, 75, 0.3);">
                            <i class="fas fa-store"></i>
                        </div>
                        <div>
                            <div style="font-size: 16px; font-weight: 600; color: #1f2937;">WhatsApp Store</div>
                        </div>
                    </div>
                    <div style="position: absolute; bottom: 16px; right: 60px;">
                        <div class="card-status" style="background: rgba(50, 215, 75, 0.15); color: #059669; padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; backdrop-filter: blur(10px); border: 1px solid rgba(50, 215, 75, 0.2); box-shadow: 0 2px 8px rgba(50, 215, 75, 0.1);">{{ $profile->store_enabled ? 'Enabled' : 'Disabled' }}</div>
                    </div>
                    <div class="expand-icon" id="store-card-icon" style="position: absolute; bottom: 16px; right: 16px; background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-chevron-down" style="color: #6b7280;"></i>
                    </div>
                </div>
                <div class="card-content" id="store-card-content">
                    <div class="card-content-inner">
                        <form action="{{ route('dashboard.store-settings.update') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex items-center justify-between bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 border border-white/20">
                                <div>
                                    <div class="font-semibold text-sm text-gray-800">Enable Store</div>
                                    <div class="text-xs text-gray-500">Allow customers to buy products</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" name="store_enabled" value="1" {{ $profile->store_enabled ? 'checked' : '' }} onchange="toggleStorePreview(this)">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            
                            <button type="submit" class="liquid-glass-btn w-full">
                                <div class="btn-content">
                                    <i class="fas fa-save btn-icon"></i>
                                    <span class="btn-text">Save Settings</span>
                                </div>
                                <div class="btn-shine"></div>
                            </button>
                        </form>

                        @if($profile->store_enabled)
                            <div class="space-y-3 mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('dashboard.store') }}" class="liquid-glass-btn btn-success w-full">
                                    <div class="btn-content">
                                        <i class="fas fa-cog btn-icon"></i>
                                        <span class="btn-text">Manage Store</span>
                                    </div>
                                    <div class="btn-shine"></div>
                                </a>
                                @if($qrCode)
                                    <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="liquid-glass-btn btn-primary w-full">
                                        <div class="btn-content">
                                            <i class="fas fa-external-link-alt btn-icon"></i>
                                            <span class="btn-text">View Store</span>
                                        </div>
                                        <div class="btn-shine"></div>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- JavaScript for Collapsible Functionality -->
        <script>
            function toggleCard(cardId) {
                const content = document.getElementById(cardId + '-content');
                const icon = document.getElementById(cardId + '-icon');
                
                if (!content || !icon) return;
                
                // Add ripple effect to icon
                createRipple(icon);
                
                if (content.classList.contains('expanded')) {
                    // Collapse
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.classList.remove('expanded');
                    icon.classList.remove('expanded');
                    
                    requestAnimationFrame(() => {
                        content.style.maxHeight = '0px';
                    });
                } else {
                    // Expand
                    content.classList.add('expanded');
                    icon.classList.add('expanded');
                    
                    requestAnimationFrame(() => {
                        content.style.maxHeight = content.scrollHeight + 'px';
                    });
                    
                    // Reset max-height after animation
                    setTimeout(() => {
                        if (content.classList.contains('expanded')) {
                            content.style.maxHeight = '3000px';
                        }
                    }, 500);
                }
            }
            
            function createRipple(element) {
                const ripple = document.createElement('span');
                const rect = element.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (rect.width / 2 - size / 2) + 'px';
                ripple.style.top = (rect.height / 2 - size / 2) + 'px';
                ripple.classList.add('ripple-effect');
                
                element.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }

            // Gallery upload functionality
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('gallery-upload-form');
                const uploadBtn = document.getElementById('upload-btn');
                const btnText = document.getElementById('btn-text');
                
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Show loading state
                        uploadBtn.disabled = true;
                        btnText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
                    });
                }
            });

            function removeProfileImage() {
                if (confirm('Remove profile image?')) {
                    document.getElementById('remove-profile-form').submit();
                }
            }

            function removeBackgroundImage() {
                if (confirm('Remove background image?')) {
                    document.getElementById('remove-background-form').submit();
                }
            }

            function dismissInAppMessage() {
                fetch('/dashboard/pwa-settings/send-notification', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ message: '' })
                }).then(() => {
                    document.getElementById('inapp-message-banner').style.display = 'none';
                });
            }

            // Unified Menu System
            function toggleUnifiedMenu() {
                const dropdown = document.getElementById('unified-menu-dropdown');
                dropdown.classList.toggle('show');
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const unifiedMenuBtn = event.target.closest('.unified-menu-btn');
                const unifiedMenuDropdown = document.getElementById('unified-menu-dropdown');

                if (!unifiedMenuBtn && !unifiedMenuDropdown.contains(event.target)) {
                    unifiedMenuDropdown.classList.remove('show');
                }
            });

            // Close menu when clicking on navigation links
            document.addEventListener('click', function(event) {
                if (event.target.closest('.menu-nav-item')) {
                    const dropdown = document.getElementById('unified-menu-dropdown');
                    setTimeout(() => dropdown.classList.remove('show'), 150);
                }
            });

            // Toggle Store Preview
            function toggleStorePreview(checkbox) {
                const storeSection = checkbox.closest('.collapsible-card');
                const statusElement = storeSection.querySelector('.card-status');
                
                if (checkbox.checked) {
                    statusElement.textContent = 'Enabled';
                    statusElement.style.background = '#ecfdf5';
                    statusElement.style.color = '#059669';
                    
                    // Add subtle animation
                    checkbox.parentElement.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        checkbox.parentElement.style.transform = 'scale(1)';
                    }, 200);
                } else {
                    statusElement.textContent = 'Disabled';
                    statusElement.style.background = '#fef2f2';
                    statusElement.style.color = '#dc2626';
                    
                    // Add subtle animation
                    checkbox.parentElement.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        checkbox.parentElement.style.transform = 'scale(1)';
                    }, 200);
                }
            }

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>
    </div>
@endsection
