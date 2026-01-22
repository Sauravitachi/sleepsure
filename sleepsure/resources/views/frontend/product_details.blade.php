@extends('layouts.app')
@section('title', $product->name)
@section('content')
<style>
      /* =========================================== */
  /* CSS VARIABLES & GLOBAL RESET - UPDATED COLORS */
  /* =========================================== */

  :root {
      /* Updated Color Variables */
      --text-dark: #333;
      --text-light: #fff;
      --alert-red: #ff0000;
      --sleepsure-blue: #1b4e9b;
      /* Primary Blue */
      --sleepsure-green: #429e39;
      /* Accent Green */
      --light-blue-bg: #e5f0ff;
      --light-green-bg: #f0fff0;

      /* Spacing Variables */
      --spacing-xs: 5px;
      --spacing-sm: 10px;
      --spacing-md: 15px;
      --spacing-lg: 20px;
      --spacing-xl: 30px;
      --spacing-xxl: 40px;

      /* Border Radius */
      --border-radius-sm: 4px;
      --border-radius-md: 8px;
      --border-radius-lg: 12px;
      --border-radius-xl: 15px;

      /* Shadows */
      --shadow-light: 0 2px 5px rgba(0, 0, 0, 0.05);
      --shadow-medium: 0 4px 10px rgba(0, 0, 0, 0.1);
      --shadow-heavy: 0 6px 15px rgba(0, 0, 0, 0.1);

      /* Custom Layout Variables */
      --sidebar-width: 280px;
  }

  /* Global Reset & Base Styles */
  * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;

      body {
          font-family: "Inter", sans-serif;
      }

  }

  a {
      text-decoration: none !important;
      color: var(--text-dark);
  }



  /* Utility Classes */
  .desktop-only {
      display: none;
  }

  @media (min-width: 1024px) {
      .desktop-only {
          display: flex;
      }

      .mobile-section {
          display: none;
      }
  }

  @media (max-width:768px) {
      .find-mattress-banner {
          display: block !important;
      }

      .find-mattress-banner .headline {
          font-size: 24px !important;
      }

      .find-mattress-banner .subtext {
          font-size: 16px !important;
      }

      .find-mattress-banner .cta-button {
          padding: 8px 12px !important;
          font-size: 12px !important;
      }
  }

  /* =========================================== */
  /* LAYOUT COMPONENTS - UPDATED COLORS */
  /* =========================================== */

  /* --- Top Alert Bar --- */
  .top-alert-bar {
      background-color: var(--sleepsure-blue);
      color: white;
      text-align: center;
      padding: var(--spacing-sm) var(--spacing-sm);
      font-size: 14px;
  }

  .top-alert-bar strong {
      font-weight: 700;
  }

  /* --- Main Header / Navbar --- */
  .main-header {
      background-color: #ebecfb;
      padding: var(--spacing-sm) 0;
  }

  .header-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 0 auto;
      padding: 0 var(--spacing-md);
  }

  /* Brand Logo */
  .brand-logo {
      display: flex;
      align-items: center;
      color: var(--sleepsure-blue);
      font-weight: 700;
      font-size: 24px;
      margin-right: var(--spacing-lg);
      text-transform: lowercase;
  }

  .home-icon {
      width: 124px;
      margin-right: var(--spacing-xs);
      background-color: transparent;
  }

  .brand-text {
      font-size: 18px;
  }

  /* Search Bar */
  .search-container {
      flex-grow: 1;
      display: flex;
      align-items: center;
      background-color: whitesmoke;
      border-radius: var(--border-radius-sm);
      padding: var(--spacing-xs) var(--spacing-sm);
      max-width: 600px;
      border: 1px solid #e0e0e0;
      box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
  }

  .search-icon {
      color: var(--sleepsure-blue);
      margin-right: var(--spacing-xs);
      font-size: 20px;
  }

  .search-input {
      border: none;
      outline: none;
      flex-grow: 1;
      padding: var(--spacing-xs) 0;
      font-size: 14px;
      background-color: whitesmoke;
  }

  .search-input::placeholder {
      color: #999;
  }

  /* Desktop Links & Icons */
  .header-links a {
      color: var(--sleepsure-blue);
      margin-left: var(--spacing-lg);
      font-size: 14px;
      opacity: 1;
  }

  .header-icons {
      display: flex;
      align-items: center;
      color: var(--sleepsure-blue);
      margin-left: var(--spacing-lg);
  }

  .header-icons a {
      color: var(--sleepsure-blue);
  }

  .header-icons .material-icons {
      font-size: 24px;
      margin-left: var(--spacing-md);
      cursor: pointer;
  }

  .account-icon {
      display: flex;
      align-items: center;
  }

  /* --- Desktop Category Navigation --- */


  .category-nav {
      background-color: var(--sleepsure-blue);
      padding: var(--spacing-sm) 0;
      border-bottom: 1px solid #ddd;
  }

  .nav-list-items {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      justify-content: center;

  }

  .nav-item {
      padding: 15px 20px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 500;
      color: white;

  }

  /* --- Mattress Dropdown Trigger (Key Positioning) --- */
  .nav-container {
      position: relative;
  }

  .nav-item-mat {

      padding: 0;
  }

  .nav-link-mat {
      display: block;
      text-decoration: none;
      color: white;

      padding: 15px 20px;
      font-weight: 500;
      transition: color 0.2s;
  }



  /* 🛑 DROPDOWN PANEL: DEFAULT STATE (HIDDEN) */
  .mat-dropdown-container {
      display: none;
      /* HIDE BY DEFAULT */
      position: absolute;

      left: -40px;
      top: 100%;

      width: auto;
      background-color: white;
      border: 1px solid var(--border-light);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      z-index: 999;
      padding: 20px 0;
      box-sizing: border-box;
  }




  .nav-item-mat:hover .mat-dropdown-container {
      display: flex;
      justify-content: space-between;
  }


  .nav-item-mat:hover .nav-link-mat {

      border-bottom: 2px solid var(--sleepsure-green);
      margin-bottom: -2px;
      /* Pulls up to hide gap between header and dropdown */
  }

  /* --- Column Styles --- */
  .dropdown-col {
      flex: 1;
      padding: 0 15px;
      border-right: 1px solid var(--border-light);
      min-width: auto;
  }

  .dropdown-col.last-col {
      border-right: none;
  }

  .col-title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-dark);
      margin: 0 0 10px 0;
      padding-bottom: 5px;
      border-bottom: 2px solid var(--sleepsure-green);
      display: inline-block;
  }

  .col-links {
      list-style: none;
      padding: 0;
      margin: 0;
  }

  .col-links li a {
      display: block;
      text-decoration: none;
      color: var(--text-dark);
      padding: 6px 0;
      font-size: 14px;
      transition: color 0.2s, padding-left 0.2s;
  }

  .col-links li a:hover {
      color: var(--sleepsure-blue);
      padding-left: 5px;
      background-color: var(--light-blue-bg);
  }

  /* --- Mobile/Sidebar Menu --- */
  .menu-toggle-btn {
      background: none;
      border: none;
      color: var(--sleepsure-blue);
      font-size: 28px;
      padding: 0;
      cursor: pointer;
  }

  .mobile-sidebar {
      position: fixed;
      top: 0px;
      left: -400px;
      width: 380px;
      height: 100%;
      background-color: #fff;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
      z-index: 200;
      transition: left 0.3s ease-in-out;
      /* overflow-y: auto; */
  }

  .mobile-sidebar.active {
      left: 0;
  }

  .sidebar-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 199;
      display: none;
  }

  .sidebar-overlay.active {
      display: block;
  }

  .sidebar-content {
      padding: 0 var(--spacing-md);
  }

  /* Account Header */
  .sidebar-account-header {
      background-color: var(--light-blue-bg);
      padding: var(--spacing-lg) var(--spacing-md);
      display: flex;
      align-items: center;
      border-bottom: 1px solid #ddd;
      margin: 0 -15px var(--spacing-md);
  }

  .sidebar-account-header .material-icons {
      font-size: 32px;
      margin-right: var(--spacing-sm);
      color: var(--sleepsure-blue);
  }

  .account-info {
      font-size: 12px;
      font-weight: 600;
  }

  .account-info a {
      color: var(--sleepsure-blue);
      font-size: 14px;
      font-weight: 400;
      text-decoration: underline;
  }

  .pincode-entry {
      padding-left: 42px;
      font-size: 14px;
      align-items: center;
  }

  .pincode-entry .location-icon,
  .pincode-entry .edit-icon {
      font-size: 16px;
      color: var(--sleepsure-blue);
      margin-right: var(--spacing-xs);
  }

  /* Utility Buttons */
  .sidebar-utility-buttons {
      display: flex;
      justify-content: space-between;
      margin-bottom: var(--spacing-lg);
  }

  .utility-btn {
      flex: 1;
      background-color: var(--light-blue-bg);
      border: 1px solid #e0e0e0;
      color: var(--text-dark);
      padding: var(--spacing-sm) var(--spacing-xs);
      margin: 0 var(--spacing-xs);
      border-radius: var(--border-radius-md);
      font-size: 12px;
      font-weight: 600;
      display: flex;
      flex-direction: column;
      align-items: center;
      cursor: pointer;
      transition: background-color 0.2s;
  }

  .utility-btn:hover {
      background-color: #e8e3ed;
  }

  .utility-btn .material-icons {
      font-size: 24px;
      margin-bottom: var(--spacing-xs);
      color: var(--sleepsure-blue);
  }

  /* Menu Links */
  .sidebar-menu-links a,
  .zense-dropdown-link {
      display: flex;
      align-items: center;
      padding: 12px 0;
      font-size: 16px;
      color: var(--text-dark);
      border-bottom: 1px solid #eee;
      width: 100%;
      cursor: pointer;
  }

  .sidebar-menu-links a:last-child {
      border-bottom: none;
  }

  .sidebar-menu-links .material-icons {
      margin-right: var(--spacing-md);
      color: var(--sleepsure-blue);
      font-size: 20px;
  }

  .zense-dropdown-link a {
      justify-content: space-between;
  }

  .new-badge {
      background-color: var(--sleepsure-green);
      color: white;
      padding: 2px 6px;
      border-radius: var(--border-radius-sm);
      font-size: 10px;
      font-weight: 600;
      margin-left: var(--spacing-sm);
  }

  .sidebar-menu-links hr {
      border: none;
      border-top: 1px solid #ddd;
      margin: var(--spacing-xs) 0;
  }

  /* =========================================== */
  /* MAIN CONTENT SECTIONS - UPDATED COLORS */
  /* =========================================== */

  /* --- Category Slider Section --- */
  .category-slider-section {
      margin-top: -4px;
      padding: var(--spacing-xxl);
      /* background: linear-gradient(#ffffff, #e9ffe7, var(--sleepsure-blue)); */
      /* background: #fff; */
      background: linear-gradient(#ffffff, #e9ffe7, var(--sleepsure-blue));

  }

  .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--spacing-lg);
      padding: 0 var(--spacing-lg);
  }

  .section-header h2 {
      font-size: 2em;
      font-weight: 700;
      color: var(--sleepsure-blue);
      display: inline-flex;
      align-items: center;
      gap: var(--spacing-sm);
      margin: 0;
  }

  .view-all {
      font-size: 14px;
      text-decoration: none;
      color: var(--sleepsure-blue);
      font-weight: 600;
  }

  /* Drag/Swipe Slider */
  .category-slider-wrapper {
      overflow-x: auto;
      overflow-y: hidden;
      padding: var(--spacing-sm) var(--spacing-lg) var(--spacing-lg);
      -webkit-overflow-scrolling: touch;
      scrollbar-width: none;
      scroll-snap-type: x mandatory;
  }

  .category-slider-wrapper::-webkit-scrollbar {
      display: none;
  }

  .category-slider {
      display: flex;
      gap: var(--spacing-lg);
  }

  .category-item {
      flex-shrink: 0;
      width: 160px;
      scroll-snap-align: start;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: var(--spacing-md);
      border-radius: var(--border-radius-md);
      /* background-color: var(--sleepsure-blue); */
      background-color: white;
      box-shadow: var(--shadow-light);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: 1px solid #eee;
  }

  .category-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-heavy);
  }

  .category-image {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      overflow: hidden;
      margin-bottom: var(--spacing-sm);
      border: 3px solid var(--sleepsure-green);
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #fffbe6;
  }

  .category-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
  }

  .category-item h3 {
      font-size: 16px;
      color: #000;
      margin: var(--spacing-xs) 0 3px;
      white-space: nowrap;
  }

  .category-item p {
      font-size: 12px;
      color: #0e0e0e;
      margin: 0;
  }

  /* --- Banner Section --- */
  .banner2 {
      display: flex;
      justify-content: space-between;
      gap: var(--spacing-lg);
      padding: var(--spacing-xxl);
  }

  .banner2-image {
      border-radius: var(--border-radius-xl);
  }

  .banner2-image img {
      border-radius: var(--border-radius-xl);
  }

  /* --- Stores Section --- */
  .stores-section {
      padding: 60px var(--spacing-lg);
      background-color: #fff;
  }

  .stores-container {
      display: flex;
      gap: var(--spacing-xl);
      max-width: 1200px;
      margin: auto;
      background: white;
  }

  .stores-box,
  .image-box {
      flex: 1;
      background: #fff;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      display: flex;
      flex-direction: column;
      justify-content: center;
  }

  .stores-heading {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 25px;
      color: var(--sleepsure-blue);
  }

  .stores-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: var(--spacing-lg);
      margin-bottom: var(--spacing-lg);
  }

  .store-card {
      text-align: center;
      padding: var(--spacing-md) var(--spacing-xs);
      border: 1px solid #eee;
      border-radius: var(--border-radius-lg);
      background: #ebecfb;
      transition: transform 0.3s ease, box-shadow 0.3s;
  }

  .store-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
  }

  .store-card h3 {
      font-size: 16px;
      font-weight: 600;
      margin-top: var(--spacing-sm);
      margin-bottom: 0;
  }

  .store-icon {
      width: 60px;
      height: 60px;
      margin: 0 auto;
      border-radius: 50%;
      border: 2px solid var(--sleepsure-green);
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f9f9f9;
  }

  .store-icon i {
      font-size: 28px;
      color: var(--sleepsure-blue);
  }

  .view-stores-link {
      display: block;
      margin: var(--spacing-lg) auto 0 auto;
      text-align: center;
      font-weight: 700;
      color: var(--sleepsure-blue);
      text-decoration: none;
  }

  .image-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: var(--border-radius-lg);
  }

  /* --- Find Mattress Banner --- */
  .find-mattress-banner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 40px;
      padding: 32px 50px;
      background-color: var(--sleepsure-blue);
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      color: #333;
      max-width: 1200px;
      margin: 64px auto;
  }

  .find-mattress-banner .content {
      flex: 1;
  }

  .find-mattress-banner .headline {
      font-size: 2.8em;
      font-weight: 800;
      color: #fff;
      margin: 0 0 8px 0;
      line-height: 1.2;
  }

  .find-mattress-banner .subtext {
      font-size: 1.1em;
      line-height: 1.6;
      margin-bottom: 24px;
      color: #fff;
  }

  .find-mattress-banner .cta-button {
      background-color: var(--sleepsure-green);
      color: white;
      border: none;
      padding: 14px 30px;
      font-size: 1.1em;
      font-weight: bold;
      letter-spacing: 0.5px;
      cursor: pointer;
      border-radius: 50px;
      transition: background-color 0.3s, transform 0.2s;
      display: inline-flex;
      align-items: center;
      box-shadow: 0 4px 15px rgba(71, 236, 66, 0.4);
  }

  .find-mattress-banner .cta-button:hover {
      background-color: #3ac835;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(71, 236, 66, 0.5);
  }

  .find-mattress-banner .arrow {
      margin-left: 10px;
      font-size: 1.4em;
      line-height: 1;
  }

  .find-mattress-banner .mattress-image-placeholder {
      flex: 0 0 45%;
      max-width: 450px;
  }

  .find-mattress-banner .mattress-image-placeholder img {
      display: block;
      border-radius: 12px;
  }

  /* --- Modal/Pop-up Styling --- */
  .modal-overlay {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: white;
      /* overflow: auto; */
  }

  .modal-overlay.open {
      display: block;
  }

  .modal-content {
      background-color: white;
      position: absolute;
      top: 0;
      /* right: 0; */
      width: 400px;
      height: auto;
      padding: var(--spacing-lg) var(--spacing-xl);
      box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
  }

  .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #eee;
      padding-bottom: var(--spacing-md);
      margin-bottom: var(--spacing-lg);
  }

  .modal-header h3 {
      margin: 0;
      font-size: 1.5em;
      color: #fff;
  }

  .close-button {
      color: #aaa;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
  }

  .close-button:hover,
  .close-button:focus {
      color: #000;
      text-decoration: none;
  }

  .question-group {
      border: none;
      padding: 0;
      margin-bottom: 25px;
  }

  .question-group legend {
      font-weight: bold;
      font-size: 1.1em;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-md);
  }

  .question-group label {
      display: flex;
      align-items: center;
      padding: 8px 0;
      cursor: pointer;
      font-size: 0.95em;
  }

  .question-group input[type="radio"] {
      appearance: none;
      -webkit-appearance: none;
      width: 18px;
      height: 18px;
      border: 2px solid #aaa;
      border-radius: 50%;
      margin-right: var(--spacing-sm);
      position: relative;
      cursor: pointer;
  }

  .question-group input[type="radio"]:checked {
      border-color: var(--sleepsure-blue);
  }

  .question-group input[type="radio"]:checked::before {
      content: '';
      display: block;
      width: 10px;
      height: 10px;
      background-color: var(--sleepsure-blue);
      border-radius: 50%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
  }

  .submit-button {
      width: 100%;
      padding: var(--spacing-md);
      background-color: var(--sleepsure-blue);
      color: white;
      border: none;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      border-radius: var(--border-radius-sm);
      margin-top: var(--spacing-lg);
  }

  /* =========================================== */
  /* PRODUCT SECTIONS - UPDATED COLORS */
  /* =========================================== */

  /* --- SCROLLABLE WRAPPER --- */

  .featured-products {
      padding: var(--spacing-lg);

  }

  .featured-products .container {
      padding: 0;
  }

  .slider-container {
      display: flex;
      gap: 25px;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
      padding-bottom: 10px;
      -ms-overflow-style: none;
      /* IE & Edge */
      scrollbar-width: none;
      /* Firefox */
  }

  .slider-container::-webkit-scrollbar {
      display: none;
      /* Chrome, Safari */
  }

  /* --- PRODUCT CARD --- */
  .wrapper {
      margin-bottom: 30px;
      flex: 0 0 300px;
      height: 420px;
      background: white;
      border-radius: 10px;
      position: relative;
      overflow: hidden;
      transform: scale(0.95);
      transition: box-shadow 0.5s, transform 0.5s;
      scroll-snap-align: start;
  }

  .wrapper:hover {
      transform: scale(1);
      box-shadow: 5px 15px 25px rgba(0, 0, 0, 0.15);
  }

  /* --- Inner Container --- */
  .container {
      width: 100%;
      height: 100%;
  }

  .container .top {
      height: 70%;
      width: 100%;
      background-size: cover;
      background-position: center;
      position: relative;
  }

  /* Rating Badge */
  .rating-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: #fff;
      padding: 4px 8px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 3px;
      color: #333;
  }

  .rating-badge i {
      color: var(--sleepsure-green);
      font-size: 11px;
  }

  /* Wishlist */
  .wishlist-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      background: white;
      border: none;
      font-size: 16px;
      padding: 6px;
      border-radius: 50%;
      cursor: pointer;
      transition: 0.3s;
  }

  .wishlist-icon:hover {
      background: #f4f4f4;
  }

  /* Bottom Section */
  .container .bottom {
      width: 200%;
      height: 30%;
      transition: transform 0.5s;
      display: flex;
  }

  .container .bottom.clicked {
      transform: translateX(-50%);
  }

  /* LEFT SIDE */
  .container .bottom .left {
      width: 50%;
      background: #f4f4f4;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 10px;
  }

  .container .bottom .left .details h1 {
      font-size: 15px;
      margin: 0;
  }

  .container .bottom .left .details p {
      margin: 1px 0;
      color: #666;
      font-size: 12px;
  }

  .price-group {
      margin-top: 4px;
  }

  .price-group .price {
      font-weight: bold;
      color: #333;
      font-size: 14px;
  }

  .price-group .discount {
      font-size: 11px;
      color: #ff3b30;
      margin-left: 6px;
  }

  .buy {
      width: 45px;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f1f1f1;
      border-left: solid thin rgba(0, 0, 0, 0.1);
      transition: background 0.5s;
  }

  .buy i {
      font-size: 22px;
      color: var(--sleepsure-blue);
      transition: transform 0.5s;
  }

  .buy:hover {
      background: #A6CDDE;
  }

  .buy:hover i {
      transform: translateY(5px);
      color: #00394B;
  }

  /* RIGHT SIDE */
  .container .bottom .right {
      width: 50%;
      background: #A6CDDE;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 12px;
  }

  .right .done i {
      font-size: 24px;
      color: white;
  }

  .right .details {
      flex: 1;
      margin-left: 8px;
  }

  .right .details h1 {
      font-size: 14px;
      margin: 0;
  }

  .right .details p {
      font-size: 12px;
      margin: 0;
  }

  .right .remove {
      display: flex;
      align-items: center;
      justify-content: center;
      background: #BC3B59;
      width: 40px;
      height: 100%;
      transition: background 0.5s;
  }

  .right .remove:hover {
      background: #9B2847;
  }

  .right .remove i {
      font-size: 22px;
      color: white;
      transition: transform 0.5s;
  }

  .right .remove:hover i {
      transform: translateY(5px);
  }

  /* Info Circle */
  .inside {
      z-index: 9;
      background: var(--sleepsure-blue);
      width: 110px;
      height: 110px;
      position: absolute;
      top: -55px;
      right: -55px;
      border-radius: 0 0 200px 200px;
      transition: all 0.5s, border-radius 2s, top 1s;
      overflow: hidden;
  }

  .inside .icon {
      position: absolute;
      right: 65px;
      top: 65px;
      color: white;
  }

  .inside .contents {
      padding: 5%;
      opacity: 0;
      transform: translateY(-200%);
      transition: opacity 0.2s, transform 0.8s;
  }

  .inside .contents table {
      text-align: left;
      width: 100%;
      color: white;
      font-size: 11px;
  }

  .inside:hover {
      width: 100%;
      right: 0;
      top: 0;
      border-radius: 0;
      height: 70%;
  }

  .inside:hover .icon {
      opacity: 0;
      right: 12px;
      top: 12px;
  }

  .inside:hover .contents {
      opacity: 1;
      transform: translateY(0);
  }


  /* --- Trust Services Section --- */
  .trust-services-container {
      background-color: white;
      border-radius: var(--border-radius-lg);
      max-width: 1000px;
      margin: var(--spacing-xxl) auto;
      padding: var(--spacing-xl);
      display: flex;
      justify-content: space-around;
      align-items: center;
      border: 1px solid #cbc9c9;
  }

  .feature-item {
      display: flex;
      align-items: center;
      padding: var(--spacing-sm);
      flex: 1;
      min-width: 0;
      border-right: 1px solid #cbc9c9;
  }

  .new-feature-grid .feature-item {
      display: block;
      border-right: none;
  }

  .feature-item:last-child {
      border-right: none;
  }

  .feature-icon-circle {
      width: 48px;
      height: 48px;
      background-color: var(--sleepsure-blue);
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: var(--spacing-md);
      flex-shrink: 0;
  }

  .feature-icon-circle i {
      color: white;
      font-size: 1.2em;
  }

  .feature-text {
      text-align: left;
  }

  .feature-text .title {
      font-size: 1em;
      font-weight: 600;
      color: #333;
      margin: 0;
      line-height: 1.2;
  }

  .feature-text .subtitle {
      font-size: 0.9em;
      color: #777;
      margin: 0;
  }

  /* --- Deal Section --- */
  .deal-section {
      display: flex;
      justify-content: space-between;
      align-items: center;
      min-height: 100vh;
      padding: 50px;
      background: linear-gradient(#ffffff, #e9ffe7, #CECFF466);
      position: relative;
      overflow: hidden;
  }

  .content-container {
      flex: 1;
      max-width: 45%;
      position: relative;
      z-index: 10;
      margin-left: 100px;
  }

  .deal-tag {
      font-size: 1.2em;
      font-weight: 700;
      color: var(--sleepsure-green);
      letter-spacing: 2px;
      margin-bottom: var(--spacing-xs);
  }

  .text-content h1 {
      font-size: 4.5em;
      font-weight: 900;
      line-height: 1.1;
      color: #333;
      margin: 0 0 var(--spacing-lg) 0;
  }

  .description {
      font-size: 1.05em;
      color: #555;
      line-height: 1.6;
      margin-bottom: var(--spacing-xl);
  }

  .ghost-text {
      position: absolute;
      top: 50%;
      left: -150px;
      transform: rotate(270deg);
      font-size: 156px;
      font-weight: 900;
      color: rgba(27, 78, 155, 0.2);
      pointer-events: none;
      z-index: 5;
      user-select: none;
      line-height: 0.8;
      z-index: 0;
  }

  .countdown-timer {
      display: flex;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-xxl);
  }

  .timer-box {
      background-color: #fff;
      border-radius: var(--border-radius-sm);
      padding: var(--spacing-lg) var(--spacing-sm);
      width: 90px;
      text-align: center;
      box-shadow: var(--shadow-light);
  }

  .timer-box span:first-child {
      display: block;
      font-size: 2.5em;
      font-weight: 800;
      color: #333;
      line-height: 1;
  }

  .timer-box .label {
      display: block;
      font-size: 0.75em;
      font-weight: 600;
      color: var(--sleepsure-green);
      margin-top: var(--spacing-xs);
  }

  .shop-button {
      background-color: var(--sleepsure-green);
      color: white;
      padding: var(--spacing-md) var(--spacing-xl);
      border: none;
      border-radius: var(--border-radius-sm);
      font-size: 1.1em;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .shop-button:hover {
      background-color: #16407c;
  }

  .image-container {
      flex: 1;
      max-width: 50%;
      position: relative;
      display: flex;
      justify-content: flex-end;
  }

  .image-container img {
      max-width: 100%;
      height: auto;
      object-fit: contain;
      transform: translateX(50px);
  }

  .discount-badge {
      position: absolute;
      top: 50px;
      left: -50px;
      background-color: var(--sleepsure-green);
      color: white;
      width: 120px;
      height: 120px;
      border-radius: 50%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: var(--spacing-sm);
      line-height: 1;
      font-weight: 800;
      box-shadow: 0 0 0 10px rgba(255, 255, 255, 0.3);
      z-index: 20;
  }

  .discount-badge .percent {
      font-size: 2.2em;
  }

  .discount-badge .off {
      font-size: 1.1em;
      letter-spacing: 1px;
  }

  .navigation-dots {
      position: absolute;
      bottom: var(--spacing-lg);
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 8px;
      z-index: 30;
  }

  .dot {
      width: 10px;
      height: 10px;
      background-color: rgba(0, 0, 0, 0.3);
      border-radius: 50%;
      cursor: pointer;
      transition: background-color 0.3s;
  }

  .dot.active {
      background-color: var(--sleepsure-blue);
  }

  .scroll-top-button {
      position: absolute;
      bottom: var(--spacing-lg);
      right: var(--spacing-lg);
      background-color: var(--sleepsure-blue);
      color: white;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      font-size: 1.5em;
      line-height: 1;
      cursor: pointer;
      z-index: 30;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  }

  /* --- Product Tabs Section --- */
  .product-tabs-container {
      max-width: 1200px;
      width: 100%;
      margin: var(--spacing-xxl) auto;
      padding: 0 var(--spacing-lg);
  }

  .product-tabs-container .container {
      padding: 0;
  }

  .product-tabs-container .tab-navigation {
      display: flex;
      gap: var(--spacing-xl);
      border-bottom: 1px solid #ddd;
      margin-bottom: var(--spacing-xl);
  }

  .product-tabs-container .tab-button {
      background: none;
      border: none;
      padding: var(--spacing-sm) 0;
      font-size: 1.25rem;
      font-weight: 600;
      color: #888;
      cursor: pointer;
      position: relative;
      transition: color 0.3s;
  }

  .product-tabs-container .tab-button.active {
      color: #333;
  }

  .product-tabs-container .tab-button.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 3px;
      background-color: var(--sleepsure-blue);
  }

  .product-tabs-container .tab-content {
      display: none;
  }

  .product-tabs-container .tab-content.active {
      display: block;
  }

  /* =========================================== */
  /* TESTIMONIALS SECTION - UPDATED COLORS */
  /* =========================================== */





  /* faq */

  .accordion-button:not(.collapsed) {
      background-color: #e6e7f8 !important;
  }

  .faq-section {

      padding: 50px 20px;
      max-width: 900px;
      /* Constrain width similar to the image */
      margin: 0 auto;
  }

  .faq-title {
      font-size: 2.5rem;
      font-weight: 300;
      /* Lighter font weight for the title */
      color: #333;
      margin-bottom: 40px;
      text-align: center;
  }

  .accordion-item {
      border: none;
      /* Remove default Bootstrap border for a cleaner look */
      border-top: 1px solid #dcdcdc;
      /* Subtle top line for separation */
      background-color: transparent;
      /* Ensure transparent background */
      padding: 5px 0;
      /* Vertical padding for items */
  }

  /* Style for the first item's top line */
  .accordion-item:first-of-type {
      border-top: 1px solid #dcdcdc;
  }

  .accordion-item:last-of-type {
      border-bottom: 1px solid #dcdcdc;
      /* Add a bottom line for the last item */
  }

  .accordion-button {
      background-color: transparent;
      color: #333;
      font-weight: 400;
      /* Regular font weight for questions */
      font-size: 1.1rem;
      /* Slightly larger font size */
      padding: 1rem 0;
      /* Adjust internal padding */
      box-shadow: none !important;
      /* Remove focus shadow */
  }

  .accordion-button:not(.collapsed) {
      color: #333;
      /* Color when active */
      background-color: transparent;
      border-bottom: 1px solid #dcdcdc;
      /* Line under the active header */
  }

  .accordion-button::after {
      /* Custom plus/minus icon for the right side, using a common Bootstrap symbol for the plus */
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23333' class='bi bi-plus' viewBox='0 0 16 16'%3E%3Cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3E%3C/svg%3E") !important;
  }

  .accordion-button:not(.collapsed)::after {
      /* Custom icon for the minus sign when expanded */
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23333' class='bi bi-dash' viewBox='0 0 16 16'%3E%3Cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3E%3C/svg%3E") !important;
  }

  .accordion-body {
      padding: 1rem 0 1.5rem 0;
      /* Adjust padding for content */
      color: #555;
      font-size: 0.95rem;
      line-height: 1.6;
  }

  .first-question-header {
      font-weight: bold;
      font-size: 1.1rem;
      margin-bottom: 10px;
      color: #333;
  }

  .first-question-body {
      color: #555;
      font-size: 0.95rem;
      line-height: 1.6;
  }

  /* Style for the first, already open question */
  .first-q-container {
      border-top: 1px solid #dcdcdc;
      padding: 15px 0;
      margin-bottom: 10px;
  }

  .first-q-close-icon {
      float: right;
      font-size: 1.5rem;
      color: #333;
      line-height: 1.2;
      cursor: pointer;
  }

  /* =========================================== */
  /* FOOTER SECTIONS - UPDATED COLORS */
  /* =========================================== */

  /* --- Primary Footer --- */
  .site-footer {
      background-color: var(--sleepsure-blue);
      color: #f4f4f4;
      padding: 50px var(--spacing-lg) var(--spacing-lg);
      font-family: Arial, sans-serif;
      position: relative;
      overflow: hidden;
  }

  .site-footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url("../images/footer-bg.png");
      background-repeat: no-repeat;
      background-position: top left;
      background-size: auto;
      opacity: 0.1;
      z-index: 1;
  }

  .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      gap: var(--spacing-xl);
      padding-bottom: var(--spacing-xl);
      position: relative;
      z-index: 2;
  }

  .footer-column {
      flex: 1;
      min-width: 200px;
  }

  .footer-heading {
      font-size: 1.2rem;
      color: #e9f2ff;
      margin-bottom: 18px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  .footer-logo {
      font-size: 1.8rem;
      color: #fff;
      margin-bottom: var(--spacing-md);
      font-weight: 900;
  }

  .footer-mission {
      font-size: 0.9rem;
      line-height: 1.6;
      margin-bottom: var(--spacing-lg);
  }

  .footer-links {
      list-style: none;
      padding: 0;
      margin: 0;
  }

  .footer-links li {
      margin-bottom: var(--spacing-sm);
  }

  .footer-links a,
  .footer-contact p a {
      color: #f4f4f4;
      text-decoration: none;
      font-size: 0.95rem;
      transition: color 0.3s ease;
  }

  .footer-column p {
      margin-bottom: var(--spacing-sm);
  }

  .footer-links a:hover,
  .footer-contact p a:hover {
      color: #fff;
      text-decoration: underline;
  }

  .newsletter-form {
      display: flex;
  }

  .social-links a {
      color: #f4f4f4;
      font-size: 1.2rem;
      margin-right: var(--spacing-md);
      transition: color 0.3s ease;
  }

  .social-links a:hover {
      color: var(--sleepsure-green);
  }

  .footer-newsletter-heading {
      margin-top: 25px;
  }

  .newsletter-form input[type="email"] {
      padding: var(--spacing-sm);
      border: none;
      border-radius: var(--border-radius-sm) 0 0 var(--border-radius-sm);
      width: 70%;
      box-sizing: border-box;
      background-color: rgba(255, 255, 255, 0.1);
      color: #f4f4f4;
  }

  .newsletter-form input[type="email"]::placeholder {
      color: #ccc;
  }

  .newsletter-form button {
      padding: var(--spacing-sm);
      border: none;
      background-color: var(--sleepsure-green);
      color: white;
      cursor: pointer;
      border-radius: 0 var(--border-radius-sm) var(--border-radius-sm) 0;
      width: 30%;
      transition: background-color 0.3s ease;
  }

  .newsletter-form button:hover {
      background-color: #3ac835;
  }

  .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.2);
      padding-top: var(--spacing-lg);
      text-align: center;
      font-size: 0.85rem;
      color: #ccc;
      position: relative;
      z-index: 2;
  }

  /* --- Secondary Footer --- */
  .sleepsure-main-footer {
      background-color: #e5e0ed;
      color: #4a4a4a;
      padding: var(--spacing-xl) var(--spacing-lg) 0;
      font-family: Arial, sans-serif;
      font-size: 0.9rem;
      line-height: 1.5;
  }

  .footer-grid-container {
      max-width: 1100px;
      margin: 0 auto;
      display: flex;
      flex-wrap: wrap;
      gap: var(--spacing-md);
      padding-bottom: var(--spacing-lg);
      justify-content: space-between;
  }

  .footer-column-item {
      width: 24%;
      min-width: 230px;
      margin-bottom: var(--spacing-lg);
  }

  .footer-title {
      font-size: 0.95rem;
      color: var(--sleepsure-blue);
      margin-bottom: 8px;
      font-weight: 700;
      text-transform: uppercase;
  }

  .footer-retail-heading,
  .footer-design-heading {
      margin-top: 25px;
  }

  .footer-nav-list {
      list-style: none;
      padding: 0;
      margin: 0;
  }

  .footer-nav-list li {
      margin-bottom: 4px;
  }

  .footer-nav-list a {
      color: #4a4a4a;
      text-decoration: none;
      font-size: 0.85rem;
  }

  .footer-nav-list a:hover {
      color: var(--sleepsure-blue);
      text-decoration: underline;
  }

  .footer-category-title {
      font-weight: bold;
      color: var(--sleepsure-blue);
      font-size: 0.9rem;
      margin: var(--spacing-md) 0 var(--spacing-xs) 0;
  }

  .footer-category-title:first-child {
      margin-top: 0;
  }

  .footer-category-list li {
      margin-bottom: 2px;
  }

  .footer-payment-info,
  .footer-trusted-info {
      color: #4a4a4a;
      font-size: 0.85rem;
      line-height: 1.4;
      margin-bottom: var(--spacing-md);
  }

  .footer-logo-container {
      display: block;
  }

  .footer-logo-container img {
      aspect-ratio: 3/2;
      object-fit: contain;
      width: 60px;
  }

  .footer-copyright-bar {
      border-top: 1px solid #d3d3d3;
      padding: var(--spacing-md) 0;
      text-align: left;
      font-size: 0.8rem;
      color: #6a6a6a;
      max-width: 1100px;
      margin: 0 auto;
  }

  .footer-copyright-bar p {
      margin: 0;
      text-align: center;
  }

  /* =========================================== */
  /* RESPONSIVE DESIGN */
  /* =========================================== */

  /* --- Mobile-Specific Adjustments (max-width: 1023px) --- */
  @media (max-width: 1023px) {
      .header-container {
          justify-content: space-between;
      }

      .search-container {
          order: 3;
          max-width: 35px;
          padding: var(--spacing-xs);
          background: none;
      }

      .brand-logo {
          margin-right: 0;
      }

      .header-icons .material-icons {
          margin-left: var(--spacing-sm);
      }

      .search-input {
          display: none;
      }

      .desktop-only,
      .category-nav {
          display: none !important;
      }

      .hero-section {
          display: none;
      }

      .mobile-section img {
          border-radius: 0px 0px var(--spacing-lg) var(--spacing-lg);
      }

      .mobile-section {
          display: block;
      }
  }

  @media (max-width:991px) {
      .scroll-container {
          overflow-x: auto !important;
      }
  }

  @media (min-width:991px) {
      .text-col {
          padding: 25px 115px !important;
      }
  }

  @media (max-width: 768px) {
      .page-title {
          font-size: 22px !important;
          text-align: center;
      }

      .commitment-section-header h2 {
          font-size: 22px !important;
          text-align: center;
      }

      .text-col {
          padding: 25px !important;

      }

      .home-icon {
          width: 90px;
          margin-right: var(--spacing-xs);
          margin-left: var(--spacing-md);
          background-color: transparent;
      }

      .mobile-sidebar {
          width: 280px !important;
      }

      .category-slider-section {
          padding: var(--spacing-sm) !important;
          margin-top: 12px !important;
      }

      .section-header h2 {
          font-size: 18px !important;
      }

      .banner2 {
          display: block !important;
          padding: var(--spacing-sm) !important;
      }

      .stores-section {
          padding: 0px !important;
      }

      .modal-content {
          width: 100% !important;
      }

      .trust-services-container {
          flex-direction: column;
      }

      .feature-item {
          width: 100%;
          flex: none;
          border-right: none !important;
      }

      .find-mattress-banner {
          margin: 0 auto !important;
          border-radius: none !important;
      }

      .text-content h1 {
          font-size: 24px !important;
      }

      .deal-section {
          display: block !important;
          padding: var(--spacing-sm) !important;
      }

      .content-container {
          max-width: 100% !important;
          margin-left: 0px !important;
      }

      .timer-box span {
          font-size: 11px !important;
      }

      .image-container {
          max-width: 100% !important;
      }

      .discount-badge {
          left: 0px !important;
          width: 75px !important;
          height: 75px !important;
      }

      .ghost-text {
          color: rgba(27, 78, 155, 0.1) !important;
      }

      .discount-badge .percent {
          font-size: 16px !important;
      }

      .section-title {
          font-size: 24px !important;
      }

      .header-decoration {
          top: 54px !important;
          left: 29px !important;
          width: 252px !important;
      }



      .product-image-container {
          height: 200px !important;
      }

      /* Stores Section Mobile */
      .stores-container {
          flex-direction: column;
      }

      .stores-box,
      .image-box {
          flex: none;
          width: auto;
          padding: var(--spacing-lg);
          margin-bottom: var(--spacing-lg);
      }

      .stores-heading {
          text-align: center;
          font-size: 22px;
      }

      .stores-grid {
          grid-template-columns: repeat(2, 1fr);
          gap: var(--spacing-md);
      }

      .store-card {
          padding: var(--spacing-sm);
      }

      .store-icon {
          width: 55px;
          height: 55px;
      }

      .store-icon i {
          font-size: 24px;
      }

      .view-stores-link {
          text-align: center;
      }



      #desktopMainVideoArea,
      #sidebarVideos {
          display: none;
      }

      #mainCarousel {
          display: flex;
          overflow-x: scroll;
          scroll-snap-type: x mandatory;
          -webkit-overflow-scrolling: touch;
          padding: 0 var(--spacing-lg);
          gap: var(--spacing-lg);
          box-sizing: border-box;
          width: 100%;
      }

      .main-video-card {
          flex-shrink: 0;
          width: 90vw;
          max-width: 450px;
          scroll-snap-align: center;
          box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
          border-radius: var(--border-radius-sm);
          background: #fff;
          padding-bottom: var(--spacing-lg);
          border: 2px solid transparent;
      }

      .main-video-card.active-mobile {
          border-color: var(--sleepsure-blue);
      }

      .video-player {
          border-radius: var(--border-radius-sm) var(--border-radius-sm) 0 0;
      }

      .main-testimonial-text {
          margin-top: var(--spacing-md);
          padding: 0 var(--spacing-lg);
      }

      .sidebar-dots {
          display: flex;
          flex-direction: row;
          justify-content: center;
          align-items: center;
          margin-top: var(--spacing-lg);
          gap: var(--spacing-sm);
      }

      .sidebar-dots span {
          width: 8px;
          height: 8px;
          background-color: rgba(27, 78, 155, 0.3);
          border-radius: 50%;
          transition: background-color 0.3s, transform 0.3s;
          cursor: pointer;
      }

      .sidebar-dots span.active {
          background-color: var(--sleepsure-blue);
          transform: scale(1.2);
      }

      /* Footer Mobile */
      @media (max-width: 992px) {
          .footer-column {
              min-width: 45%;
          }

          .footer-container {
              justify-content: space-around;
          }
      }

      @media (max-width: 576px) {
          .footer-column {
              min-width: 100%;
              text-align: center;
              margin-bottom: var(--spacing-lg);
          }

          .footer-brand,
          .footer-contact {
              text-align: center;
          }

          .social-links {
              display: flex;
              justify-content: center;
          }

          .newsletter-form {
              display: flex;
              justify-content: center;
          }

          .newsletter-form input[type="email"],
          .newsletter-form button {
              width: 50%;
          }

          .footer-column-item {
              width: 100%;
              min-width: unset;
              margin-bottom: var(--spacing-lg);
          }

          .footer-grid-container {
              gap: 0;
          }

          .footer-copyright-bar {
              text-align: center;
          }
      }

      /* Product Cards Mobile */
      @media (max-width: 1024px) {
          .product-card {
              width: calc((100vw - 40px - 40px) / 3);
              min-width: 200px;
          }
      }

      @media (max-width: 768px) {
          .product-card {
              width: calc((100vw - 40px - 20px) / 2);
              min-width: 160px;
          }
      }

      @media (max-width: 480px) {
          .product-card {
              width: calc(100vw - 80px);
          }

          .slider-container {
              padding: 0 var(--spacing-sm);
          }
      }

      /* Smallest Mobile Devices */
      @media (max-width: 480px) {
          .stores-grid {
              grid-template-columns: 1fr 1fr;
          }
      }
  }

  /* --- Chat Button --- */
  .chat-button {
      position: fixed;
      bottom: var(--spacing-lg);
      right: var(--spacing-lg);
      background-color: var(--sleepsure-blue);
      color: white;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      z-index: 1000;
  }

  /* bank offer */
  .offers-section {
      width: 100%;
      padding: var(--spacing-xxl);
      text-align: center;
      margin: 0 auto;
      background: #CECFF466;
  }

  .offers-section h2 {
      font-size: 28px;
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
  }

  .offers-section h2 span {
      font-size: 28px;
      color: #fbbf24;
  }

  .filter-buttons {
      margin-bottom: 30px;
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
  }

  .filter-buttons button {
      border: 1px solid #ccc;
      background: #fff;
      padding: 8px 18px;
      border-radius: 50px;
      cursor: pointer;
      font-size: 14px;
      transition: all 0.3s ease;
  }

  .filter-buttons button.active,
  .filter-buttons button:hover {
      border-color: var(--sleepsure-blue);
      color: var(--sleepsure-blue);
      font-weight: 500;
  }

  .offers-cards {
      display: flex;
      justify-content: center;
      gap: 20px;
      /* flex-wrap: wrap; */
  }

  .offer-card {
      background: linear-gradient(135deg, #c6c2fb 0%, var(--sleepsure-blue) 100%);
      width: 150px;
      border-radius: 15px;
      padding: 20px;
      color: #fff;
      text-align: center;
      transition: transform 0.3s ease;
      cursor: pointer;
      display: none;
      /* hide all initially */
  }

  .offer-card img {
      aspect-ratio: 3 / 2;
      width: 100%;
      /* height: 60px; */
      object-fit: contain;

  }

  .offer-card p {
      font-size: 16px;
      font-weight: 500;
      margin: 0;
  }

  .offer-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }


  .text-col {
      padding: 25px 125px;
  }

  .text-col h2 {
      color: var(--sleepsure-blue);
  }


  /* ------------------------------------------- */
  /* --- IMPROVED MODERN TWO-COLUMN CSS --- */
  /* ------------------------------------------- */

  .commitment-section {
      max-width: 1200px;
      margin: var(--spacing-xxl) auto;
      /* padding: 0 var(--spacing-lg); */
  }

  .commitment-section-header {
      text-align: center;
      margin-bottom: var(--spacing-xl);
  }

  .commitment-section-header h2 {
      font-size: 2.2em;
      font-weight: 800;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-sm);
  }

  .commitment-section-header p {
      color: var(--text-dark);
      font-size: 1.1em;
  }

  /* Main Container Card (Unified Look) */
  .modern-two-col-card {
      display: flex;
      background-color: var(--text-light);
      /* White background */
      border-radius: var(--border-radius-xl);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      /* Soft, deep shadow */
      overflow: hidden;
      margin-top: var(--spacing-xxl);
  }

  .card-column {
      flex: 1;
      padding: var(--spacing-xxl);
  }

  /* Separator Line */
  .modern-two-col-card .why-choose-us-content {
      /* Right border acts as the separator line */
      border-right: 1px solid var(--light-blue-bg);
  }

  /* Column Header */
  .card-column h3 {
      font-size: 1.6em;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: var(--spacing-xl);
  }

  /* ----------------------------------- */
  /* --- 1. WHY CHOOSE US Feature Items --- */
  /* ----------------------------------- */

  .feature-item-modern {
      display: flex;
      align-items: flex-start;
      margin-bottom: var(--spacing-lg);
      padding-bottom: var(--spacing-sm);
      border-bottom: 1px dashed var(--light-blue-bg);
      /* Subtle separator */
  }

  .feature-item-modern:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
  }

  .feature-item-modern i {
      color: var(--sleepsure-green);
      /* Positive accent color */
      font-size: 1.5em;
      margin-right: var(--spacing-md);
      margin-top: 5px;
      flex-shrink: 0;
  }

  .feature-item-modern h4 {
      color: var(--sleepsure-blue);
      font-size: 1.1em;
      margin-bottom: var(--spacing-xs);
  }

  .feature-item-modern p {
      color: var(--text-dark);
      font-size: 0.95em;
      line-height: 1.5;
  }

  /* ----------------------------------- */
  /* --- 2. MISSION & VISION Items --- */
  /* ----------------------------------- */

  .mv-item-modern {
      margin-bottom: var(--spacing-xl);
      padding: var(--spacing-md);
      background-color: rgba(27, 78, 155, 0.05);
      /* Very light blue background for contrast */
      border-left: 5px solid var(--sleepsure-blue);
      border-radius: var(--border-radius-sm);
  }

  .mv-item-modern:last-child {
      margin-bottom: 0;
  }

  .mv-heading-modern {
      display: flex;
      align-items: center;
      margin-bottom: var(--spacing-sm);
      font-weight: 700;
      font-size: 1.3em;
      color: var(--sleepsure-blue);
  }

  .mv-heading-modern i {
      font-size: 1.3em;
      margin-right: var(--spacing-sm);
      color: var(--sleepsure-green);
      /* Icon color contrast */
  }

  .mv-item-modern p {
      color: var(--text-dark);
      line-height: 1.6;
  }

  /* Responsive Design: Stacking sections on mobile/tablet */
  @media (max-width: 900px) {
      .modern-two-col-card {
          flex-direction: column;
          /* Stack vertically */
      }

      .modern-two-col-card .why-choose-us-content {
          border-right: none;
          border-bottom: 1px solid var(--light-blue-bg);
          /* Separator on bottom */
      }
  }



  .complain {
      background: #CECFF466;
  }

  .text-col-2 .card-1 {
      border-radius: 0px 0px 70px 0px;
      background-color: #CECFF433;
  }

  .text-col-2 .card-2 {
      border-radius: 70px 0px 0px 0px;
      background-color: #CECFF433;
      margin-top: -30px;
      position: relative;
      overflow: hidden;
      /* 🔹 so radius applies */
  }

  .text-col-2 .card-2 img {
      border-radius: 70px 0 0 0;
  }

  .text-col-2 .card-2::before {
      border-radius: 70px 0 0 0;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      content: "";
      background: url(../images/Vector.png) center/contain no-repeat;
      z-index: -1;
  }

  .text-col-2 .card-3 {
      border-radius: 0px 0px 70px 0px;
      background-color: #CECFF433;
  }

  .text-col-2 p {
      padding: 15px;
      font-family: Poppins, sans-serif;
      font-weight: 400;
      font-size: 16px;
      line-height: 27px;
      margin: 0;
  }

  /* ====== MOBILE DRAG SCROLL (without JS) ====== */
  @media (max-width: 768px) {
      .main-col {
          display: flex;
          flex-wrap: nowrap;
          overflow-x: auto;
          scroll-snap-type: x mandatory;
          -webkit-overflow-scrolling: touch;
          gap: 15px;
      }

      .main-col::-webkit-scrollbar {
          display: none;
          /* hide scrollbar */
      }

      .col-md-4 {
          flex: 0 0 80%;
          /* each card width on mobile */
          scroll-snap-align: start;
      }

      /* remove margin gap issue on small screens */
      .text-col-2 .card-2 {
          margin-top: 0;
      }
  }

  .two-column-section {
      max-width: 1200px;
      margin: var(--spacing-xxl) auto;
      padding: 0 var(--spacing-lg);
  }

  .two-column-section h2 {
      text-align: center;
      font-size: 2em;
      color: var(--text-dark);
      margin-bottom: var(--spacing-xl);
      font-weight: 700;
  }

  /* Main Grid/Flex Container: To place both sections in one row */
  .card-row-container {
      display: flex;
      /* Flexbox for horizontal layout */
      gap: var(--spacing-lg);
  }

  /* Base Card Styling (For both sections) */
  .base-card {
      flex: 1;
      /* Both cards take equal space */
      padding: var(--spacing-xxl) var(--spacing-xl);
      border-radius: var(--border-radius-xl);
      box-shadow: var(--shadow-medium);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .base-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-heavy);
  }

  /* ----------------------------------- */
  /* --- 1. WHY CHOOSE US (Green Theme) --- */
  /* ----------------------------------- */
  .why-choose-us-card {
      background-color: var(--light-green-bg);
      border: 2px solid var(--sleepsure-green);
  }

  .why-choose-us-card h3 {
      color: var(--sleepsure-green);
      font-size: 1.5em;
      margin-bottom: var(--spacing-lg);
      border-bottom: 2px solid rgba(66, 158, 57, 0.2);
      padding-bottom: var(--spacing-sm);
  }

  .feature-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: var(--spacing-md);
      color: var(--text-dark);
  }

  .feature-item i {
      color: var(--sleepsure-green);
      font-size: 1.2em;
      margin-right: var(--spacing-sm);
      margin-top: 3px;
      /* Icon alignment */
      flex-shrink: 0;
  }

  .feature-item p strong {
      font-weight: 700;
  }

  /* ----------------------------------- */
  /* --- 2. MISSION & VISION (Blue Theme) --- */
  /* ----------------------------------- */
  .mission-vision-card {
      background-color: var(--light-blue-bg);
      border: 2px solid var(--sleepsure-blue);
  }

  .mission-vision-card h3 {
      color: var(--sleepsure-blue);
      font-size: 1.5em;
      margin-bottom: var(--spacing-lg);
      border-bottom: 2px solid rgba(27, 78, 155, 0.2);
      padding-bottom: var(--spacing-sm);
  }

  .mv-item {
      margin-bottom: var(--spacing-xl);
  }

  .mv-item .mv-heading {
      display: flex;
      align-items: center;
      margin-bottom: var(--spacing-sm);
      font-weight: 700;
      font-size: 1.2em;
      color: var(--sleepsure-blue);
  }

  .mv-item .mv-heading i {
      font-size: 1.5em;
      margin-right: var(--spacing-sm);
  }

  .mv-item p {
      color: var(--text-dark);
      line-height: 1.6;
  }

  /* Responsive Design: Stacking sections on mobile/tablet */
  @media (max-width: 900px) {
      .card-row-container {
          flex-direction: column;
          /* Stack vertically on smaller screens */
      }

      .base-card {
          margin-bottom: var(--spacing-lg);
      }
  }


  .complain {
      background: #CECFF466;
      padding-top: var(--spacing-lg);
  }

  .text-col-2 .card-1 {
      border-radius: 0px 0px 70px 0px;
      background-color: #CECFF433;
  }

  .text-col-2 .card-2 {
      border-radius: 70px 0px 0px 0px;
      background-color: #CECFF433;
      margin-top: -30px;
      position: relative;
      overflow: hidden;
      /* 🔹 so radius applies */
  }

  .text-col-2 .card-2 img {
      border-radius: 70px 0 0 0;
  }

  .text-col-2 .card-2::before {
      border-radius: 70px 0 0 0;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      content: "";
      background: url(../images/Vector.png) center/contain no-repeat;
      z-index: -1;
  }

  .text-col-2 .card-3 {
      border-radius: 0px 0px 70px 0px;
      background-color: #CECFF433;
  }

  .text-col-2 p {
      padding: 15px;
      font-family: Poppins, sans-serif;
      font-weight: 400;
      font-size: 16px;
      line-height: 27px;
      margin: 0;
  }

  /* ====== MOBILE DRAG SCROLL (without JS) ====== */
  @media (max-width: 768px) {
      .main-col {
          display: flex;
          flex-wrap: nowrap;
          overflow-x: auto;
          scroll-snap-type: x mandatory;
          -webkit-overflow-scrolling: touch;
          gap: 15px;
      }

      .main-col::-webkit-scrollbar {
          display: none;
          /* hide scrollbar */
      }

      .col-md-4 {
          flex: 0 0 80%;
          /* each card width on mobile */
          scroll-snap-align: start;
      }

      /* remove margin gap issue on small screens */
      .text-col-2 .card-2 {
          margin-top: 0;
      }
  }

  /* ------------------------------------------- */
  /* --- NEW SECTION: SIZE CATEGORY CARDS CSS --- */
  /* ------------------------------------------- */

  .new-shop-by-size-section {
      max-width: 1400px;
      margin: var(--spacing-xxl) auto;
      padding: var(--spacing-lg) 0;
  }

  .new-section-header {
      text-align: center;
      margin-bottom: var(--spacing-xl);
  }

  .new-section-header h2 {
      font-size: 2em;
      font-weight: 700;
      color: var(--text-dark);
  }

  /* 1. FLEX LAYOUT for Cards (Updated for Draggability) */
  .size-category-grid {
      display: flex;
      /* Changed from grid to flex */
      gap: var(--spacing-lg);
      padding: 0 var(--spacing-md);

      /* SCROLL & DRAG PROPERTIES */
      overflow-x: scroll;
      /* Enable horizontal scrolling */
      overflow-y: hidden;
      scroll-behavior: smooth;
      scroll-snap-type: x mandatory;
      /* Snap to card start */
      cursor: grab;
      /* Cursor change to indicate dragability */

      /* HIDE SCROLLBAR */
      scrollbar-width: none;
      /* Firefox */
      -ms-overflow-style: none;
      /* IE and Edge */
  }

  .size-category-grid::-webkit-scrollbar {
      display: none;
      /* Chrome, Safari, Opera */
  }


  /* 2. INDIVIDUAL CARD STYLING (Added flex-shrink) */
  .size-category-card {
      flex-shrink: 0;
      /* Critical: prevents cards from shrinking */
      width: 300px;
      /* Define width for desktop */
      scroll-snap-align: start;
      /* Snap point */

      display: flex;
      flex-direction: column;
      height: 350px;
      border-radius: var(--border-radius-xl);
      overflow: hidden;
      text-decoration: none;
      color: var(--text-light);
      position: relative;
      cursor: pointer;
      box-shadow: var(--shadow-medium);

      /* Background Image setup */
      background-size: cover;
      background-position: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .size-category-card::before {
      /* Subtle overlay for better text readability */
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.1));
      z-index: 1;
  }

  .size-category-card:hover {
      transform: translateY(-5px);
      /* Lift effect on hover */
      box-shadow: var(--shadow-heavy);
  }

  /* 3. CARD CONTENT & TEXT */
  .card-content {
      margin-top: auto;
      /* Push content to the bottom */
      padding: var(--spacing-lg);
      position: relative;
      z-index: 2;
      /* Keep content above the overlay */
  }

  .card-content h3 {
      font-size: 1.6em;
      margin-bottom: var(--spacing-xs);
      font-weight: 700;
  }

  .card-content p {
      font-size: 0.95em;
      margin-bottom: var(--spacing-md);
      opacity: 0.8;
  }

  /* 4. SHOP NOW BUTTON/LINK STYLE */
  .shop-now-btn {
      display: inline-flex;
      align-items: center;
      font-weight: 600;
      color: var(--text-light);
      text-decoration: underline;
      text-underline-offset: 4px;
      transition: color 0.3s ease;
  }

  .shop-now-btn i {
      margin-left: var(--spacing-xs);
      transition: margin-left 0.3s ease;
  }

  .size-category-card:hover .shop-now-btn i {
      margin-left: var(--spacing-sm);
      /* Arrow moves slightly on hover */
  }

  /* 5. RECOMMENDED CARD (Queen) STYLING */
  .recommended-card {
      border: 3px solid var(--sleepsure-green);
      /* Green border for accent */
  }

  .badge {
      position: absolute;
      top: var(--spacing-md);
      right: var(--spacing-md);
      background: var(--sleepsure-green);
      color: var(--text-light);
      padding: var(--spacing-xs) var(--spacing-sm);
      border-radius: var(--border-radius-sm);
      font-size: 0.8em;
      font-weight: 700;
      letter-spacing: 0.5px;
      z-index: 2;
  }

  /* Responsive adjustments for smaller screens */
  @media (max-width: 1024px) {

      /* On tablet, cards remain scrollable but look slightly smaller */
      .size-category-card {
          width: 350px;
      }
  }

  @media (max-width: 600px) {
      .new-shop-by-size-section {
          /* Reduce margin/padding on mobile */
          margin: var(--spacing-xl) auto;
      }

      .size-category-grid {
          /* Add padding to show drag shadow better */
          padding: 0 var(--spacing-sm);
      }

      .size-category-card {
          /* Mobile: Make card fill most of the screen width for easy swiping */
          width: 85vw;
          height: 250px;
      }
  }

  /* --- Responsive Adjustments --- */

  /* Tablet and Smaller Desktop View (Max width 1024px) */
  @media (max-width: 1024px) {
      .mattress-features-container {
          padding: 20px;
      }

      .features-header {
          /* Aligning 3 columns, but allowing wrap */
          flex-wrap: wrap;
          justify-content: space-around;
          gap: 20px;
      }

      .feature-point {
          /* Allows two feature points per row on smaller tablets */
          max-width: 45%;
      }

      .features-footer {
          /* Aligning 2 columns, but allowing wrap */
          flex-wrap: wrap;
          justify-content: center;
          gap: 20px;
          margin-top: 30px;
      }
  }

  /* Mobile View (Max width 768px) */
  @media (max-width: 768px) {

      .features-header,
      .features-footer {
          flex-direction: column;
          /* Stack all items vertically */
          padding: 10px 0;
          gap: 25px;
      }

      .feature-point {
          max-width: 100%;
          /* Full width for single column layout */
          padding-left: 25px;
          /* Adjust padding for dot/number alignment */
          text-align: left;
      }

      .feature-point h2 {
          font-size: 1.3em;
      }

      /* Adjust the position of the overlay number to look good in full width */
      .feature-point::after {
          font-size: 3.5em;
          top: -5px;
          left: 25px;
          /* Matches the new padding-left */
      }

      .green-dot {
          top: 8px;
          /* Slightly lower position for better alignment with new h2 size */
      }

      /* Ensure the image scales down correctly */
      .mattress-image {
          max-width: 90%;
          height: auto;
      }
  }

  .layer {
      background: #CECFF466;
  }

  .mattress-features-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px;

      border-radius: 8px;

  }

  .features-header,
  .features-footer {
      display: flex;
      justify-content: space-between;
      padding: 20px 0;
      margin-bottom: 20px;
      gap: 30px;
  }

  .features-footer {
      margin-top: 40px;
      justify-content: space-around;
      gap: 100px;
  }

  /* --- Feature Point Styling with Overlay --- */
  .feature-point {
      flex: 1;
      max-width: 350px;
      position: relative;
      padding-left: 20px;
      /* Space for the green dot */
  }

  /* 1. The Green Dot */
  .green-dot {
      position: absolute;
      left: 0;
      top: 5px;
      width: 10px;
      height: 10px;
      background-color: #38c172;
      /* Green dot color */
      border-radius: 50%;
  }

  .feature-point h2 {
      font-size: 1.2em;
      font-weight: bold;
      color: #333;
      margin-top: 0;
      margin-bottom: 5px;
      position: relative;
      /* Important: ensures text is layered above the pseudo-element */
      z-index: 2;
      /* Ensures text is on top of the overlay number */
  }

  /* 2. The Overlay Number using ::after */
  .feature-point::after {
      content: attr(data-number);
      /* Gets the number from the HTML attribute */
      position: absolute;

      /* Positioning the number behind the heading text */
      top: -10px;
      left: 20px;

      font-size: 3em;
      /* Large size */
      font-weight: 700;
      /* Bold */

      color: #38c172;
      /* Green color for the number */
      opacity: 0.1;
      /* Light/Faded effect (Critical for overlay look) */
      z-index: 1;
      /* Ensures the number is behind the text (h2) */

      /* Optional: to make the number slightly blurry for a softer effect */
      text-shadow: 0 0 5px rgba(56, 193, 114, 0.2);
  }

  .feature-point p {
      font-size: 14px;
      line-height: 1.5;
      color: #666;
  }

  /* --- Image Section Styling --- */
  .mattress-diagram-section-image {
      display: flex;
      justify-content: center;

  }

  /* --- 1. Main Section and Background Styling --- */
  .money-back-guarantee-section {
      /* Main background color from the image: Light Lavender/Blue */

      padding: 80px 20px;
      position: relative;
      overflow: hidden;
      /* Prevents background elements from spilling out */
      border-radius: 0 0 50px 50px;
      /* Optional: Top corners are slightly rounded */
  }

  .money-back-guarantee-section::before,
  .money-back-guarantee-section::after {
      content: '';
      position: absolute;
      width: 250px;
      /* Adjust size based on your vector image */
      height: 350px;
      /* Adjust size based on your vector image */
      background-repeat: no-repeat;
      opacity: 1;
      /* Make them subtle */
      pointer-events: none;
      z-index: 1;
  }

  /* Left side vector */
  .money-back-guarantee-section::before {
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      /* Replace with your left side vector image */
      background-image: url('../images/icon/v1.png');
      background-size: contain;
  }


  /* Right side vector */
  .money-back-guarantee-section::after {
      bottom: 0;
      right: 0;
      /* Replace with your right side vector image */
      background-image: url('../images/icon/v2.png');
      background-size: cover;
  }


  /* --- 2. Content and Header Styling --- */
  .content-container {
      max-width: 1100px;
      margin: 0 auto;
      text-align: center;
      position: relative;
      /* Ensure content is above CSS vectors (z-index: 2) */
      z-index: 2;
  }

  .tagline {
      font-size: 0.85em;
      font-weight: 600;
      letter-spacing: 2px;
      color: #4a4a8f;
      /* Dark blue/purple */
      margin-bottom: 5px;
  }

  h1 {
      font-size: 2.5em;
      font-weight: 700;
      color: #1a1a3a;
      margin-bottom: 10px;
  }

  .subtitle {
      font-size: 1.1em;
      color: #4a4a8f;
      margin-bottom: 50px;
      font-weight: 500;
  }


  /* --- 3. Feature Grid and Items (Four Columns) --- */
  .feature-grid {
      display: flex;
      justify-content: space-around;
      gap: 30px;
      flex-wrap: wrap;
      /* Allows wrapping on smaller screens */
  }

  .feature-item {
      flex-basis: 250px;
      /* Controls column width */
      text-align: center;
      position: relative;
      padding-bottom: 20px;
  }

  /* Icon Wrapper and Vector Shape */
  .icon-wrapper {
      position: relative;
      width: 80px;
      height: 80px;
      margin: 0 auto 20px auto;
      display: flex;
      align-items: center;
      justify-content: center;
      background-repeat: no-repeat;

      background-position: center;
  }

  .icon-wrapper img {
      width: 60px;
      /* Icon size */
      height: 60px;
      z-index: 3;
      /* Icon should be on top */
      position: relative;
  }

  /* The Subtle Shape Behind the Icon */
  .icon-wrapper::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0.6;
      /* Light and subtle */
      z-index: 2;
  }

  .icon-wrapper-1 {
      background-image: url(../images/icon/1.png)
  }

  .icon-wrapper-2 {
      background-image: url(../images/icon/2.png)
  }

  .icon-wrapper-3 {
      background-image: url(../images/icon/3.png)
  }

  .icon-wrapper-4 {
      background-image: url(../images/icon/4.png)
  }

  /* Feature Item Headings and Text */
  .feature-item h3 {
      font-size: 1.1em;
      font-weight: 600;
      color: #1a1a3a;
      margin-bottom: 10px;
  }

  .feature-item p {
      font-size: 0.9em;
      line-height: 1.5;
      color: #4a4a8f;
      margin: 0 auto;
      max-width: 200px;
      /* Keeps text concise */
  }

  /* The Small Dark Blue Triangle Shape at the bottom */
  .triangle-shape {
      width: 0;
      height: 0;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-top: 15px solid #4a4a8f;
      /* Dark blue color */
      margin: 20px auto 0 auto;
  }

  /* --- 4. Responsive Adjustments --- */
  @media (max-width: 850px) {
      .feature-grid {
          justify-content: center;
      }

      .feature-item {
          flex-basis: 40%;
          /* Two columns on tablets */
          margin-bottom: 40px;
      }
  }

  @media (max-width: 550px) {
      .feature-item {
          flex-basis: 90%;
          /* One column on phones */
      }

      h1 {
          font-size: 2em;
      }
  }

  /* --- Section Container --- */
  .reviews-section {
      background-color: #f0f3f8;
      padding: 80px 20px;
      position: relative;
      overflow: hidden;
      /* Contains the overall section */
  }

  /* --- Reviews Header (No change needed) --- */
  .reviews-header {
      max-width: 1100px;
      margin: 0 auto 50px auto;
      text-align: left;
  }

  .section-tag {
      display: flex;
      align-items: center;
      font-size: 0.85em;
      font-weight: 600;
      letter-spacing: 1.5px;
      color: #509b57;
      margin-bottom: 10px;
  }

  .tag-line {
      width: 25px;
      height: 2px;
      background-color: #509b57;
      margin-right: 10px;
  }

  .reviews-header h2 {
      font-size: 2.5em;
      font-weight: 700;
      color: #1a1a3a;
      margin-top: 0;
  }

  /* ------------------------------------------------------------------ */
  /* --- CSS SCROLL-SNAP SLIDER IMPLEMENTATION --- */
  /* ------------------------------------------------------------------ */

  .testimonials-container {
      /* Remove max-width/margin/center to allow full-width scrolling */
      margin: 0;
      /* Remove auto margins */
      padding: 0 50px;
      /* Add padding for cards to not touch the edges */

      display: flex;
      gap: 30px;

      /* The key for horizontal scrolling */
      overflow-x: scroll;
      overflow-y: hidden;

      /* Hides the horizontal scrollbar for a cleaner look (optional) */
      -ms-overflow-style: none;
      /* IE and Edge */
      scrollbar-width: none;
      /* Firefox */

      /* The magic for slider-like stopping */
      scroll-snap-type: x mandatory;
      scroll-padding-left: 50px;
      /* Important to align the first card cleanly */

      /* Disable user select on the container to prevent accidental text selection while dragging/swiping */
      user-select: none;
  }

  /* Hide the scrollbar in supported browsers */
  .testimonials-container::-webkit-scrollbar {
      display: none;
  }


  /* --- Testimonial Card --- */
  .testimonial-card {
      background-color: #f7f7fc;
      border-radius: 15px;
      padding: 40px;
      text-align: left;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);

      /* Essential for flexbox scrolling */
      flex: 0 0 350px;
      /* Do not grow, do not shrink, fix width at 350px */

      /* The magic for snapping to the card */
      scroll-snap-align: start;

      /* Ensure all cards have a consistent height for clean scrolling */
      min-height: 300px;

      display: flex;
      flex-direction: column;
      justify-content: space-between;

      transition: transform 0.3s ease;
  }

  /* Styles for content inside the card remain largely the same */
  .quote-icon {
      font-family: 'Georgia', serif;
      font-size: 4em;
      font-weight: bold;
      color: #d8e6d9;
      line-height: 0.8;
      margin-bottom: 20px;
      display: block;
  }

  .review-text {
      font-size: 1em;
      line-height: 1.6;
      color: #4a4a8f;
      margin-bottom: 20px;
      flex-grow: 1;
  }

  .reviewer-name {
      font-size: 1.1em;
      font-weight: 700;
      color: #1a1a3a;
      margin-bottom: 5px;
  }

  .reviewer-location {
      font-size: 0.85em;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.5px;
  }

  /* --- Navigation Arrows (Removed/Hidden) --- */
  /* Remove styles for .nav-arrow, .left-arrow, .right-arrow and the SVG path */
  /* as the elements themselves were removed from the HTML. */
  .nav-arrow {
      display: none !important;
  }

  /* ------------------------------------------------------------------ */
  /* --- Responsive Adjustments --- */
  /* ------------------------------------------------------------------ */

  @media (max-width: 1024px) {
      .testimonials-container {
          gap: 20px;
          scroll-padding-left: 20px;
          /* Adjust snap padding */
          padding: 0 20px;
          /* Adjust section padding */
      }

      .testimonial-card {
          flex: 0 0 300px;
          /* Narrow card slightly */
          padding: 30px;
      }
  }

  /* ... (All previous desktop/large screen styles) ... */

  /* --- Responsive Adjustments --- */
  @media (max-width: 768px) {
      /* ... (Header centering styles) ... */

      .testimonials-container {
          /* FIX: Ensure cards stay on one line for scrolling */
          flex-wrap: nowrap;

          /* Adjust padding/spacing for a better look */
          padding: 0 20px;
          scroll-padding-left: 20px;
      }

      .testimonial-card {
          /* Card width is set relative to the viewport for smooth snapping */
          flex: 0 0 calc(90vw - 40px);
          /* 90% of screen width (vw) for the card + some for padding/gap */
          min-height: 280px;
      }
  }

  @media (max-width: 480px) {
      .reviews-section {
          padding: 50px 0;
      }

      .reviews-header {
          padding: 0 20px;
      }

      .testimonials-container {
          padding: 0 20px;
          scroll-padding-left: 20px;
      }

      .reviews-header h2 {
          font-size: 2em;
      }

      .testimonial-card {
          /* On very small screens, make the card fill almost the entire width */
          flex: 0 0 calc(100vw - 40px);
          min-height: 250px;
      }
  }

  /* --- Award Section Styling --- */
  .award-section {
      padding: 60px 0;
      background-color: #ffffff;
      /* White background */
      text-align: center;
  }

  .award-section h2 {
      font-size: 2em;
      font-weight: 700;
      color: #1a1a3a;
      margin-bottom: 40px;
  }

  /* --- Slider Container (The Magic Part) --- */
  .award-slider-container {
      display: flex;
      overflow-x: auto;
      /* Enables horizontal scrolling */

      /* --- CSS Scroll Snap Properties for Slider Effect --- */
      scroll-snap-type: x mandatory;
      /* Snap items to the x-axis */
      -webkit-overflow-scrolling: touch;
      /* Better scrolling on iOS */

      /* Hide the scrollbar (optional, but makes it cleaner) */
      scrollbar-width: none;
      /* Firefox */
      -ms-overflow-style: none;
      /* IE and Edge */
      padding: 10px 0 30px 0;
      /* Add padding for visual space */
      margin: 0 auto;
      max-width: 1200px;
  }

  /* Webkit scrollbar hide */
  .award-slider-container::-webkit-scrollbar {
      display: none;
  }

  /* --- Individual Award Item --- */
  .award-item {
      flex: 0 0 250px;
      /* Item width is fixed at 250px */
      scroll-snap-align: center;
      /* Snap the center of the item to the snap point */
      margin: 0 15px;
      padding: 20px;
      border-radius: 10px;
      background-color: #f7f7f7;
      /* Light grey background for cards */
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      text-align: center;
      transition: transform 0.3s ease;
  }

  .award-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  }

  .award-image {
      width: 150px;
      height: 150px;
      object-fit: contain;
      margin-bottom: 15px;
      border-radius: 50%;
      /* Optional: If you want a circular award image look */
      border: 3px solid #f7c700;
      /* Gold border effect */
  }

  .award-title {
      font-size: 1.1em;
      font-weight: 600;
      color: #333;
      margin-bottom: 5px;
  }

  .award-source {
      font-size: 0.9em;
      color: #888;
  }


  /* become a dealer */
  /* Blurred Background */
  .modal-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
  }

  .modal-backdrop.active {
      opacity: 1;
      visibility: visible;
  }

  /* Modal Content */
  .dealer-modal {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      width: 90%;
      max-width: 500px;
      transform: translateY(-20px);
      transition: transform 0.3s ease;
      overflow: hidden;
  }

  .modal-backdrop.active .dealer-modal {
      transform: translateY(0);
  }

  .modal-header {
      background: var(--sleepsure-blue);
      color: white;
      padding: 20px;
      text-align: center;
      position: relative;
  }

  .modal-header h2 {
      margin: 0;
      font-size: 1.5rem;
  }

  .close-btn {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
      transition: opacity 0.3s;
  }

  .close-btn:hover {
      opacity: 0.8;
  }

  .modal-body {
      padding: 30px;
  }

  .form-group {
      margin-bottom: 20px;
  }

  .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: var(--text-dark);
  }

  .form-group input {
      width: 100%;
      padding: 12px 15px;
      /* border: 2px solid #e0e0e0; */
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s;
  }

  .form-group input:focus {
      outline: none;
      border-color: var(--sleepsure-blue);
  }

  .user-type-group {
      margin-bottom: 20px;
  }

  .user-type-label {
      display: block;
      margin-bottom: 10px;
      font-weight: 600;
      color: var(--text-dark);
  }

  .radio-options {
      display: flex;
      gap: 20px;
  }

  .radio-option {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
  }

  .radio-option input[type="radio"] {
      width: auto;
      margin: 0;
  }

  .checkbox-group {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 25px;
  }

  .checkbox-group input[type="checkbox"] {
      width: auto;
  }

  .checkbox-group label {
      margin: 0;
      font-weight: normal;
  }

  .submit-btn {
      width: 100%;
      background: var(--sleepsure-green);
      color: white;
      border: none;
      padding: 15px;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
  }

  .submit-btn:hover {
      background: #36852f;
  }



  .become-dealer-btn:hover {
      color: #153a73;
  }



  /* product detail page start */
  .product-page-container {
      /* max-width: 1200px; */
      margin: 0 auto;
      padding: var(--spacing-lg);
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-light);
      /* margin-top: var(--spacing-lg); */
  }

  .section-title {
      font-size: 1.5em;
      font-weight: 600;
      margin-bottom: var(--spacing-md);
      color: var(--sleepsure-blue);
  }

  hr {
      border: none;
      border-top: 1px solid #e2e8f0;
      margin: var(--spacing-xl) 0;
  }

  /* Product View Section */
  .product-view-section {
      display: flex;
      gap: var(--spacing-xl);
      padding-top: var(--spacing-lg);
  }

  .product-gallery {
      width: 60%;
      display: flex;
      gap: var(--spacing-md);
  }

  /* Thumbnails on Left Side */
  .thumbnails {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-sm);
      /* width: 80px; */
      padding: 20px;
      background-color: #e5f0ff;
  }

  .thumbnails img {
      width: 100%;
      height: 120px;
      width: 120px;
      border: 5px solid #fff;
      border-radius: var(--border-radius-lg);
      cursor: pointer;
      object-fit: cover;
      transition: all 0.3s ease;
  }

  .thumbnails img:hover {
      border-color: var(--sleepsure-blue);
      transform: scale(1.05);
  }

  .thumbnails img.active {
      border-color: var(--sleepsure-blue);
      border-width: 2px;
  }

  .main-image-container {
      flex: 1;
      border-radius: var(--border-radius-md);
      overflow: hidden;
  }

  .main-image-container img {
      width: 100%;
      height: 700px;
      object-fit: cover;
  }

  /* Product Details */
  .product-details {
      width: 40%;

  }

  .product-name {
      font-size: 1.3em;
      font-weight: 600;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-xs);
  }

  .product-variant-info {
      color: #64748b;
      margin-bottom: var(--spacing-md);
  }

  .rating-and-cart-info {
      display: flex;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-lg);
  }

  .rating-stars {
      border: 1px solid rgb(230 231 232);
      color: black;
      padding: var(--spacing-xs) var(--spacing-sm);
      border-radius: var(--border-radius-sm);
      font-weight: 600;
  }

  .cart-info {
      color: black;
      font-weight: 500;
      border: 1px solid rgb(230 231 232);
      padding: 0px 10px;
      border-radius: var(--border-radius-sm);
      display: flex;
      align-items: center;
  }

  .price-section {
      margin-bottom: var(--spacing-lg);
  }

  .sale-badge {
      background: var(--alert-red);
      color: white;
      padding: var(--spacing-xs);
      border-radius: var(--border-radius-sm);
      font-size: 0.8em;
      font-weight: 600;
      margin-right: var(--spacing-sm);
  }

  .sale-ends {
      color: var(--alert-red);
      font-size: 0.8em;
      font-weight: 600;
  }

  .price-figures {
      display: flex;
      align-items: center;
      gap: var(--spacing-md);
      margin-top: var(--spacing-sm);
  }

  .current-price {
      font-size: 1.8em;
      font-weight: 700;
  }

  .old-price {
      text-decoration: line-through;
      color: #94a3b8;
  }

  .discount-percent {
      background: var(--sleepsure-green);
      color: white;
      padding: var(--spacing-xs);
      border-radius: var(--border-radius-sm);
      font-weight: 600;
  }

  .tax-info {
      color: #64748b;
      font-size: 0.8em;
      margin-top: var(--spacing-xs);
  }

  /* Equal Size Delivery and Size Sections */
  .delivery-and-size {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-lg);
  }

  .check-delivery,
  .choose-size-container {
      display: flex;
      flex-direction: column;
  }

  .check-delivery label,
  .choose-size-container label {
      font-weight: 600;
      color: #475569;
      margin-bottom: var(--spacing-xs);
      font-size: 0.9em;
  }

  .pincode-input {
      display: flex;
      border: 1px solid #e2e8f0;
      border-radius: var(--border-radius-md);
      overflow: hidden;
  }

  .pincode-input input {
      border: none;
      padding: var(--spacing-md);
      flex: 1;
      outline: none;
      font-size: 12px;
  }

  .pincode-input button {
      background: var(--sleepsure-blue);
      color: white;
      border: none;
      padding: var(--spacing-md) var(--spacing-lg);
      cursor: pointer;
      font-weight: 600;
      font-size: 12px;
  }

  .size-dropdown {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: var(--spacing-md);
      border: 1px solid var(--sleepsure-blue);
      background: var(--light-blue-bg);
      border-radius: var(--border-radius-md);
      cursor: pointer;
      font-weight: 600;
      color: var(--sleepsure-blue);
      font-size: 12px;
  }

  .size-dropdown .standard-options {
      font-size: 0.8em;
      color: #64748b;
  }

  /* Add to Cart Button */
  .add-to-cart-btn {
      width: 100%;
      padding: var(--spacing-md);
      background: var(--sleepsure-blue);
      color: white;
      border: none;
      border-radius: var(--border-radius-md);
      font-weight: 600;
      cursor: pointer;
      margin-bottom: var(--spacing-lg);
      transition: background 0.3s;
  }

  .add-to-cart-btn:hover {
      background: #153a73;
  }

  /* Bank Card Style Offers */
  .save-extra-section h2 {
      font-size: 1.1em;
      font-weight: 600;
      margin-bottom: var(--spacing-md);
      color: var(--sleepsure-blue);
  }

  .offers-container {
      overflow-x: auto;
      padding-bottom: var(--spacing-sm);
      /* Hide scrollbar but keep functionality */
      scrollbar-width: none;
      /* Firefox */
  }

  .offers-container::-webkit-scrollbar {
      display: none;
      /* Chrome, Safari, Edge */
  }

  .offers-track {
      display: flex;
      gap: var(--spacing-md);
      width: max-content;
  }

  .offer-card2 {
      min-width: 280px;
      padding: var(--spacing-sm);
      border-radius: 16px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      position: relative;
      overflow: hidden;
  }

  .offer-card2:nth-child(2) {
      background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  }

  .offer-card2:nth-child(3) {
      background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  }

  .offer-card2::before {
      content: '';
      position: absolute;
      top: -50%;
      right: -50%;
      width: 200px;
      height: 200px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
  }

  .offer-card2::after {
      content: '';
      position: absolute;
      bottom: -30%;
      left: -30%;
      width: 150px;
      height: 150px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
  }

  .offer-content {
      position: relative;
      z-index: 2;
  }

  .bank-logo {
      font-size: 1.2em;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: var(--spacing-sm);
  }

  .offer-detail {
      margin: var(--spacing-sm) 0;
  }

  .lowest-price {
      opacity: 0.9;
      font-size: 0.9em;
  }

  .price-value {
      font-size: 1.4em;
      font-weight: 700;
      margin: var(--spacing-xs) 0;
  }

  .offer-type {
      opacity: 0.9;
      font-size: 0.9em;
      margin-bottom: var(--spacing-md);
      display: flex;
      align-items: center;
      gap: var(--spacing-xs);
  }

  .view-offer-btn {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: var(--spacing-sm) var(--spacing-md);
      border-radius: 20px;
      cursor: pointer;
      font-weight: 600;
      backdrop-filter: blur(10px);
      transition: all 0.3s;
  }

  .view-offer-btn:hover {
      background: rgba(255, 255, 255, 0.3);
  }

  /* Variant Modal */
  .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      backdrop-filter: blur(5px);
  }

  .modal-overlay.active {
      display: flex;
  }

  .modal-content {
      background: white;
      border-radius: var(--border-radius-lg);
      width: 900px;
      padding: var(--spacing-xl);
      box-shadow: var(--shadow-medium);
      overflow-y: scroll;
      max-height: 100vh;
  }

  .modal-close-btn {
      background: none;
      border: none;
      font-size: 1.5em;
      cursor: pointer;
      color: #64748b;
      float: right;
      margin-bottom: var(--spacing-md);
      position: absolute;
      top: 0;
      right: 20px;
  }

  .modal-title {
      font-size: 1.3em;
      font-weight: 600;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-lg);
      clear: both;
  }

  .modal-product-header {
      display: flex;
      align-items: center;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-lg);
      padding: var(--spacing-md);
      background: var(--light-blue-bg);
      border-radius: var(--border-radius-md);
  }

  .modal-thumbnail {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: var(--border-radius-sm);
  }

  .modal-product-name {
      font-size: 0.9em;
      color: var(--sleepsure-blue);
      font-weight: 500;
  }

  .learn-measure-banner {
      background: var(--light-blue-bg);
      color: var(--sleepsure-blue);
      padding: var(--spacing-md);
      border-radius: var(--border-radius-md);
      margin-bottom: var(--spacing-lg);
      text-align: center;
      font-weight: 600;
      cursor: pointer;
  }

  .size-selection-group {
      margin-bottom: var(--spacing-lg);
  }

  .size-selection-group h3 {
      font-size: 1em;
      font-weight: 600;
      margin-bottom: var(--spacing-md);
      color: var(--sleepsure-blue);
  }

  .size-group-options,
  .dimension-options {
      display: flex;
      flex-wrap: wrap;
      gap: var(--spacing-sm);
  }

  .size-group-btn,
  .dimension-btn {
      background: white;
      border: 1px solid #e2e8f0;
      padding: var(--spacing-sm) var(--spacing-md);
      border-radius: var(--border-radius-md);
      cursor: pointer;
      font-size: 0.9em;
      transition: all 0.3s;
  }

  .size-group-btn:hover,
  .dimension-btn:hover {
      border-color: var(--sleepsure-blue);
  }

  .size-group-btn.active,
  .dimension-btn.active {
      background: var(--sleepsure-blue);
      color: white;
      border-color: var(--sleepsure-blue);
  }

  .confirm-variant-btn {
      width: 100%;
      padding: var(--spacing-md);
      background: var(--sleepsure-blue);
      color: white;
      border: none;
      border-radius: var(--border-radius-md);
      font-weight: 600;
      cursor: pointer;
      margin-top: var(--spacing-lg);
  }

  /* Product Details Section with Working Tabs */
  .product-detail-section {
      padding: var(--spacing-xl);
  }

  .detail-tabs {
      display: flex;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-lg);
      border-bottom: 1px solid #e2e8f0;
      overflow-x: auto;
      padding-bottom: var(--spacing-sm);
  }

  .tab-button {
      background: none;
      border: none;
      padding: var(--spacing-md) var(--spacing-lg);
      color: #64748b;
      cursor: pointer;
      font-weight: 500;
      position: relative;
      white-space: nowrap;
      flex-shrink: 0;
  }

  .tab-button.active {
      color: var(--sleepsure-blue);
      font-weight: 600;
  }

  .tab-button.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--sleepsure-blue);
  }

  .tab-content {
      display: none;
      animation: fadeIn 0.3s ease;
  }

  @keyframes fadeIn {
      from {
          opacity: 0;
      }

      to {
          opacity: 1;
      }
  }

  .tab-content.active {
      display: block;
  }

  /* Improved Detail Grid */
  .detail-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: var(--spacing-lg);
  }

  .detail-item {
      display: flex;
      align-items: flex-start;
      gap: var(--spacing-md);
      padding: var(--spacing-lg);
      background: white;
      border-radius: var(--border-radius-md);
      box-shadow: var(--shadow-light);
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
  }

  .detail-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-medium);
      border-color: var(--sleepsure-blue);
  }

  .icon-box {
      color: var(--sleepsure-blue);
      font-size: 1.5em;
      min-width: 50px;
      text-align: center;
      padding: var(--spacing-sm);
      background: var(--light-blue-bg);
      border-radius: var(--border-radius-md);
  }

  .text-content h3 {
      font-weight: 600;
      margin-bottom: var(--spacing-xs);
      color: var(--sleepsure-blue);
      font-size: 18px;
  }

  .text-content p {
      color: #64748b;
      font-size: 0.9em;
      line-height: 1.5;
  }

  /* Reviews Section */
  .reviews-section {
      /* padding: var(--spacing-xl) 0; */
  }

  .overall-rating-summary {
      display: flex;
      align-items: center;
      gap: var(--spacing-lg);
      margin-bottom: var(--spacing-lg);
      flex-wrap: wrap;
  }

  .overall-rating {
      font-size: 2em;
      font-weight: 700;
      color: var(--sleepsure-green);
  }

  .rating-info {
      color: #64748b;
      flex: 1;
      min-width: 200px;
  }

  .platform-ratings {
      display: flex;
      gap: var(--spacing-md);
  }

  .platform-rating {
      text-align: center;
  }

  .platform-rating .rating-stars {
      font-size: 0.9em;
      margin-bottom: var(--spacing-xs);
  }

  .customer-media-title {
      font-weight: 600;
      margin-bottom: var(--spacing-md);
      color: var(--sleepsure-blue);
  }

  .customer-media-carousel {
      display: flex;
      gap: var(--spacing-md);
      overflow-x: auto;
      margin-bottom: var(--spacing-lg);
      padding-bottom: var(--spacing-sm);
  }

  .customer-media-carousel img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: var(--border-radius-md);
  }

  .single-review-card {
      border: 1px solid #e2e8f0;
      padding: var(--spacing-md);
      border-radius: var(--border-radius-md);
  }

  .review-rating-stars {
      background: var(--sleepsure-green);
      color: white;
      padding: var(--spacing-xs);
      border-radius: var(--border-radius-sm);
      font-size: 0.8em;
      font-weight: 600;
      display: inline-block;
      margin-bottom: var(--spacing-sm);
  }

  .review-text {
      font-weight: 600;
      margin-bottom: var(--spacing-xs);
  }

  .review-comment {
      color: #64748b;
      margin-bottom: var(--spacing-md);
  }

  .reviewer-info {
      color: #94a3b8;
      font-size: 0.8em;
  }

  /* Mobile Responsive Styles */
  @media (max-width: 768px) {
      .product-page-container {
          padding: var(--spacing-md);
          margin-top: var(--spacing-sm);
      }

      .product-view-section {
          flex-direction: column;
          gap: var(--spacing-lg);
          padding-top: 0;
      }

      .product-gallery,
      .product-details {
          width: 100%;
      }

      .thumbnails {
          flex-direction: row;
          width: 100%;
          order: 2;
          margin-top: var(--spacing-md);
      }

      .thumbnails img {
          width: 60px;
          height: 60px;
      }

      .product-gallery {
          flex-direction: column;
      }

      .main-image-container img {
          height: 350px;
      }

      .delivery-and-size {
          grid-template-columns: 1fr;
          gap: var(--spacing-lg);
      }

      .detail-grid {
          grid-template-columns: 1fr;
      }

      .product-name {
          font-size: 1.3em;
      }

      .price-figures {
          flex-wrap: wrap;
      }

      .current-price {
          font-size: 1.5em;
      }

      .detail-tabs {
          flex-wrap: nowrap;
          overflow-x: auto;
      }

      .tab-button {
          padding: var(--spacing-sm) var(--spacing-md);
      }

      .detail-item {
          padding: var(--spacing-md);
          flex-direction: column;
          text-align: center;
      }

      .icon-box {
          align-self: center;
      }

      .overall-rating-summary {
          flex-direction: column;
          align-items: flex-start;
          gap: var(--spacing-md);
      }

      .rating-info {
          min-width: auto;
      }

      .platform-ratings {
          width: 100%;
          justify-content: space-between;
      }

      .modal-content {
          padding: var(--spacing-md);
          width: 95%;
      }

      .size-group-options,
      .dimension-options {
          justify-content: center;
      }
  }

  @media (max-width: 480px) {
      .product-page-container {
          padding: var(--spacing-sm);
      }

      .product-name {
          font-size: 1.2em;
      }

      .rating-and-cart-info {
          flex-direction: column;
          gap: var(--spacing-sm);
      }

      .main-image-container img {
          height: 300px;
      }

      .thumbnails img {
          width: 50px;
          height: 50px;
      }

      .offer-card2 {
          min-width: 250px;
      }

      .customer-media-carousel img {
          width: 100px;
          height: 100px;
      }

      .pincode-input {
          flex-direction: column;
      }

      .pincode-input button {
          border-radius: 0 0 var(--border-radius-md) var(--border-radius-md);
      }
  }

  /* product detail page end */



  /* cart page start */

  /* Breadcrumb */
  .breadcrumb {
      padding: var(--spacing-md) 0;
      background-color: white;
      box-shadow: var(--shadow-light);
      margin-bottom: var(--spacing-xl);
  }

  .breadcrumb-container {
      display: flex;
      align-items: center;
  }

  .breadcrumb a {
      color: var(--sleepsure-blue);
      text-decoration: none;
      transition: color 0.3s;
  }

  .breadcrumb a:hover {
      color: #153a73;
  }

  .breadcrumb span {
      margin: 0 var(--spacing-sm);
      color: #666;
  }

  /* Cart Section */
  .cart-section {
      padding: var(--spacing-xl) 0;
  }

  .cart-title {
      font-size: 2rem;
      margin-bottom: var(--spacing-xl);
      color: var(--sleepsure-blue);
      display: flex;
      align-items: center;
      gap: var(--spacing-sm);
  }

  .cart-container {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: var(--spacing-xl);
  }

  .cart-items {
      background-color: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      box-shadow: var(--shadow-light);
  }

  .cart-item {
      display: flex;
      padding: var(--spacing-lg) 0;
      border-bottom: 1px solid #eee;
  }

  .cart-item:last-child {
      border-bottom: none;
  }

  .item-image {
      width: 150px;
      height: 150px;
      border-radius: var(--border-radius-md);
      overflow: hidden;
      margin-right: var(--spacing-lg);
  }

  .item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
  }

  .item-details {
      flex: 1;
  }

  .item-name {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: var(--spacing-sm);
      color: var(--sleepsure-blue);
  }

  .item-size {
      color: #666;
      margin-bottom: var(--spacing-sm);
  }

  .item-price {
      font-weight: bold;
      font-size: 1.1rem;
      color: var(--sleepsure-green);
      margin-bottom: var(--spacing-md);
  }

  .item-actions {
      display: flex;
      gap: var(--spacing-md);
  }

  .quantity-selector {
      display: flex;
      align-items: center;
      border: 1px solid #ddd;
      border-radius: var(--border-radius-sm);
      overflow: hidden;
      width: 128px;
  }

  .quantity-btn {
      padding: var(--spacing-sm) var(--spacing-md);
      background-color: #f5f5f5;
      border: none;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s;
  }

  .quantity-btn:hover {
      background-color: #e5e5e5;
  }

  .quantity-input {
      width: 50px;
      text-align: center;
      border: none;
      padding: var(--spacing-sm) 0;
      font-weight: bold;
  }

  .remove-btn {
      background: none;
      border: none;
      color: var(--alert-red);
      cursor: pointer;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: var(--spacing-xs);
      transition: color 0.3s;
  }

  .remove-btn:hover {
      color: #cc0000;
  }

  .cart-summary {
      background-color: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      box-shadow: var(--shadow-light);
      height: fit-content;
      position: sticky;
      top: 100px;
  }

  .summary-title {
      font-size: 1.5rem;
      margin-bottom: var(--spacing-lg);
      color: var(--sleepsure-blue);
      padding-bottom: var(--spacing-sm);
      border-bottom: 1px solid #eee;
  }

  .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: var(--spacing-md);
  }

  .summary-total {
      font-weight: bold;
      font-size: 1.2rem;
      margin-top: var(--spacing-md);
      padding-top: var(--spacing-md);
      border-top: 1px solid #eee;
  }

  .summary-total .amount {
      color: var(--sleepsure-green);
  }

  .checkout-btn {
      width: 100%;
      background-color: var(--sleepsure-green);
      color: white;
      border: none;
      padding: var(--spacing-md) var(--spacing-lg);
      border-radius: var(--border-radius-md);
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-lg);
      font-size: 1.1rem;
  }

  .checkout-btn:hover {
      background-color: #36852f;
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  .continue-shopping {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-md);
      color: var(--sleepsure-blue);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
  }

  .continue-shopping:hover {
      color: #153a73;
  }

  .empty-cart {
      text-align: center;
      padding: var(--spacing-xxl) 0;
  }

  .empty-cart-icon {
      font-size: 4rem;
      color: #ddd;
      margin-bottom: var(--spacing-lg);
  }

  .empty-cart h2 {
      font-size: 1.8rem;
      margin-bottom: var(--spacing-md);
      color: var(--sleepsure-blue);
  }

  .empty-cart p {
      color: #666;
      margin-bottom: var(--spacing-xl);
      max-width: 500px;
      margin-left: auto;
      margin-right: auto;
  }

  .shop-now-btn {
      background-color: var(--sleepsure-blue);
      color: white;
      border: none;
      padding: var(--spacing-md) var(--spacing-xl);
      border-radius: var(--border-radius-md);
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: var(--spacing-sm);
      text-decoration: none;
  }

  .shop-now-btn:hover {
      background-color: #153a73;
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  /* Recently Viewed Section */
  .recently-viewed {
      margin-top: var(--spacing-xl);
      background-color: white;
      border-radius: var(--border-radius-lg);
      /* padding: var(--spacing-xl); */
      box-shadow: var(--shadow-light);
  }

  .section-title {
      font-size: 1.5rem;
      margin-bottom: var(--spacing-lg);
      color: var(--sleepsure-blue);
      position: relative;
      padding-bottom: var(--spacing-sm);
  }

  .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background-color: var(--sleepsure-green);
  }

  .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: var(--spacing-lg);
  }

  .product-card {
      border-radius: var(--border-radius-md);
      overflow: hidden;
      box-shadow: var(--shadow-light);
      transition: transform 0.3s, box-shadow 0.3s;
  }

  .product-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-medium);
  }

  .product-image {
      height: 200px;
      overflow: hidden;
  }

  .product-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
  }

  .product-card:hover .product-image img {
      transform: scale(1.05);
  }

  .product-info {
      padding: var(--spacing-md);
  }

  .product-name {
      font-weight: 600;
      margin-bottom: var(--spacing-xs);
      color: var(--sleepsure-blue);
  }

  .product-price {
      font-weight: bold;
      color: var(--sleepsure-green);
      margin-bottom: var(--spacing-sm);
  }

  .add-to-cart-small {
      width: 100%;
      background-color: var(--sleepsure-blue);
      color: white;
      border: none;
      padding: var(--spacing-sm) var(--spacing-md);
      border-radius: var(--border-radius-sm);
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-xs);
  }

  .add-to-cart-small:hover {
      background-color: #153a73;
  }


  /* Responsive Design */
  @media (max-width: 768px) {
      .cart-container {
          grid-template-columns: 1fr;
      }

      .header-container {
          /* flex-direction: column; */
          gap: var(--spacing-md);
      }

      nav ul {
          justify-content: center;
          flex-wrap: wrap;
      }

      .cart-item {
          flex-direction: column;
      }

      .item-image {
          width: 100%;
          height: 200px;
          margin-right: 0;
          margin-bottom: var(--spacing-md);
      }

      .products-grid {
          grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      }
  }

  /* cart page end */



  /* checkout page start */

  .checkout-section {
      padding: var(--spacing-xl) 0;
  }

  .checkout-title {
      font-size: 2rem;
      margin-bottom: var(--spacing-xl);
      color: var(--sleepsure-blue);
      display: flex;
      align-items: center;
      gap: var(--spacing-sm);
  }

  .checkout-container {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: var(--spacing-xl);
  }

  .checkout-form {
      background-color: white;
      border-radius: var(--border-radius-lg);
      /* padding: var(--spacing-xl); */
      /* box-shadow: var(--shadow-light); */
  }

  .form-section {
      margin-bottom: var(--spacing-xl);
  }

  .section-title {
      font-size: 1.3rem;
      margin-bottom: var(--spacing-lg);
      color: var(--sleepsure-blue);
      position: relative;
      padding-bottom: var(--spacing-sm);
      display: flex;
      align-items: center;
      gap: var(--spacing-sm);
  }

  .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 50px;
      height: 3px;
      background-color: var(--sleepsure-green);
  }

  .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-md);
  }

  .form-group {
      margin-bottom: var(--spacing-md);
  }

  .form-group label {
      display: block;
      margin-bottom: var(--spacing-xs);
      font-weight: 500;
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
      width: 100%;
      padding: var(--spacing-md);
      border: 1px solid #ddd;
      border-radius: var(--border-radius-md);
      font-size: 1rem;
      transition: border-color 0.3s, box-shadow 0.3s;
  }

  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
      outline: none;
      border-color: var(--sleepsure-blue);
      box-shadow: 0 0 0 2px rgba(27, 78, 155, 0.1);
  }

  .checkbox-group {
      display: flex;
      align-items: center;
      gap: var(--spacing-sm);
      margin-bottom: var(--spacing-md);
  }

  .checkbox-group input {
      width: auto;
  }

  .payment-methods {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-lg);
  }

  .payment-method {
      border: 2px solid #ddd;
      border-radius: var(--border-radius-md);
      padding: var(--spacing-md);
      text-align: center;
      cursor: pointer;
      transition: all 0.3s;
  }

  .payment-method:hover {
      border-color: var(--sleepsure-blue);
  }

  .payment-method.active {
      border-color: var(--sleepsure-blue);
      background-color: var(--light-blue-bg);
  }

  .payment-icon {
      font-size: 2rem;
      margin-bottom: var(--spacing-sm);
      color: var(--sleepsure-blue);
  }

  .card-details {
      display: none;
      margin-top: var(--spacing-lg);
      padding: var(--spacing-lg);
      background-color: var(--light-blue-bg);
      border-radius: var(--border-radius-md);
  }

  .card-details.active {
      display: block;
      animation: fadeIn 0.5s ease;
  }

  @keyframes fadeIn {
      from {
          opacity: 0;
      }

      to {
          opacity: 1;
      }
  }

  .card-row {
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: var(--spacing-md);
  }

  .order-summary {
      background-color: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      box-shadow: var(--shadow-light);
      height: fit-content;
      position: sticky;
      top: 100px;
  }

  .summary-title {
      font-size: 1.5rem;
      margin-bottom: var(--spacing-lg);
      color: var(--sleepsure-blue);
      padding-bottom: var(--spacing-sm);
      border-bottom: 1px solid #eee;
  }

  .order-items {
      margin-bottom: var(--spacing-lg);
  }

  .order-item {
      display: flex;
      padding: var(--spacing-md) 0;
      border-bottom: 1px solid #eee;
  }

  .order-item:last-child {
      border-bottom: none;
  }

  .order-item-image {
      width: 80px;
      height: 80px;
      border-radius: var(--border-radius-sm);
      overflow: hidden;
      margin-right: var(--spacing-md);
  }

  .order-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
  }

  .order-item-details {
      flex: 1;
  }

  .order-item-name {
      font-weight: 600;
      margin-bottom: var(--spacing-xs);
      color: var(--sleepsure-blue);
      font-size: 18px;
  }

  .order-item-size {
      color: #666;
      margin-bottom: var(--spacing-xs);
      font-size: 0.9rem;
  }

  .order-item-price {
      font-weight: bold;
      color: var(--sleepsure-green);
  }

  .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: var(--spacing-md);
  }

  .summary-total {
      font-weight: bold;
      font-size: 1.2rem;
      margin-top: var(--spacing-md);
      padding-top: var(--spacing-md);
      border-top: 1px solid #eee;
  }

  .summary-total .amount {
      color: var(--sleepsure-green);
  }

  .place-order-btn {
      width: 100%;
      background-color: var(--sleepsure-green);
      color: white;
      border: none;
      padding: var(--spacing-md) var(--spacing-lg);
      border-radius: var(--border-radius-md);
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-lg);
      font-size: 1.1rem;
  }

  .place-order-btn:hover {
      background-color: #36852f;
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  .secure-checkout {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-sm);
      margin-top: var(--spacing-md);
      color: #666;
      font-size: 0.9rem;
  }

  .secure-checkout i {
      color: var(--sleepsure-green);
  }

  /* Footer */
  footer {
      background-color: var(--sleepsure-blue);
      color: var(--text-light);
      padding: var(--spacing-xl) 0;
      /* margin-top: var(--spacing-xl); */
  }

  .footer-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: var(--spacing-xl);
  }

  .footer-section h3 {
      margin-bottom: var(--spacing-md);
      font-size: 1.2rem;
      position: relative;
      padding-bottom: var(--spacing-xs);
  }

  .footer-section h3:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 30px;
      height: 2px;
      background-color: var(--sleepsure-green);
  }

  .footer-section ul {
      list-style: none;
  }

  .footer-section ul li {
      margin-bottom: var(--spacing-xs);
  }

  .footer-section ul li a {
      color: var(--text-light);
      text-decoration: none;
      transition: opacity 0.3s;
  }

  .footer-section ul li a:hover {
      opacity: 0.8;
      padding-left: var(--spacing-xs);
  }

  .copyright {
      text-align: center;
      margin-top: var(--spacing-xl);
      padding-top: var(--spacing-md);
      border-top: 1px solid rgba(255, 255, 255, 0.1);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
      .checkout-container {
          grid-template-columns: 1fr;
      }

      .header-container {
          /* flex-direction: column; */
          gap: var(--spacing-md);
      }

      nav ul {
          justify-content: center;
          flex-wrap: wrap;
      }

      .form-row {
          grid-template-columns: 1fr;
      }

      .payment-methods {
          grid-template-columns: 1fr 1fr;
      }

      .card-row {
          grid-template-columns: 1fr;
      }
  }

  /* checkout page end */


  /* login page start */

  .auth-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--spacing-xl) 0;
      background: linear-gradient(135deg, var(--light-blue-bg) 0%, #f9f9f9 100%);
  }

  .auth-container {
      display: flex;
      width: 900px;
      max-width: 90%;
      height: 550px;
      background-color: white;
      border-radius: var(--border-radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-heavy);
  }

  .auth-image {
      flex: 1;
      background: linear-gradient(rgba(27, 78, 155, 0.7), rgba(27, 78, 155, 0.7)),
          url('https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80');
      background-size: cover;
      background-position: center;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: var(--spacing-xl);
      position: relative;
  }

  .auth-image-content {
      max-width: 80%;
  }

  .auth-image h2 {
      font-size: 2rem;
      margin-bottom: var(--spacing-md);
  }

  .auth-image p {
      font-size: 1.1rem;
      opacity: 0.9;
  }

  .auth-forms {
      flex: 1;
      padding: var(--spacing-xl);
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
      overflow: hidden;
  }

  .form-container {
      width: 100%;
      transition: transform 0.5s ease;
  }

  .form-title {
      font-size: 1.8rem;
      margin-bottom: var(--spacing-sm);
      color: var(--sleepsure-blue);
      text-align: center;
  }

  .form-subtitle {
      text-align: center;
      color: #666;
      margin-bottom: var(--spacing-xl);
  }

  .form-group {
      margin-bottom: var(--spacing-md);
  }

  .form-group label {
      display: block;
      margin-bottom: var(--spacing-xs);
      font-weight: 500;
  }

  .phone-input-container {
      display: flex;
      align-items: center;
      border: 1px solid #ddd;
      border-radius: var(--border-radius-md);
      overflow: hidden;
  }

  .country-code {
      display: flex;
      align-items: center;
      padding: var(--spacing-md);
      background-color: #f5f5f5;
      border-right: 1px solid #ddd;
      font-weight: 500;
  }

  .country-code i {
      margin-right: var(--spacing-xs);
      color: var(--sleepsure-blue);
  }

  .phone-input {
      flex: 1;
      border: none;
      padding: var(--spacing-md);
      font-size: 1rem;
      width: 100%;
  }

  .phone-input:focus {
      outline: none;
  }

  .otp-input-container {
      display: flex;
      gap: var(--spacing-sm);
      margin-bottom: var(--spacing-md);
  }

  .otp-input {
      width: 50px;
      height: 50px;
      text-align: center;
      font-size: 1.2rem;
      font-weight: bold;
      border: 1px solid #ddd;
      border-radius: var(--border-radius-md);
      transition: border-color 0.3s, box-shadow 0.3s;
  }

  .otp-input:focus {
      outline: none;
      border-color: var(--sleepsure-blue);
      box-shadow: 0 0 0 2px rgba(27, 78, 155, 0.1);
  }

  .timer {
      text-align: center;
      margin-bottom: var(--spacing-md);
      color: #666;
      font-size: 0.9rem;
  }

  .resend-otp {
      text-align: center;
      margin-bottom: var(--spacing-lg);
  }

  .resend-link {
      color: var(--sleepsure-blue);
      text-decoration: none;
      font-weight: 500;
      cursor: pointer;
      transition: color 0.3s;
  }

  .resend-link:hover {
      color: #153a73;
  }

  .resend-link.disabled {
      color: #999;
      cursor: not-allowed;
  }

  .auth-btn {
      width: 100%;
      background-color: var(--sleepsure-green);
      color: white;
      border: none;
      padding: var(--spacing-md) var(--spacing-lg);
      border-radius: var(--border-radius-md);
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 1rem;
      margin-bottom: var(--spacing-lg);
  }

  .auth-btn:hover {
      background-color: #36852f;
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  .auth-btn:disabled {
      background-color: #cccccc;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
  }

  .divider {
      display: flex;
      align-items: center;
      margin: var(--spacing-lg) 0;
  }

  .divider::before,
  .divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #ddd;
  }

  .divider span {
      padding: 0 var(--spacing-md);
      color: #666;
  }

  .social-login {
      display: flex;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-lg);
  }

  .social-btn {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-sm);
      padding: var(--spacing-md);
      border: 1px solid #ddd;
      border-radius: var(--border-radius-md);
      background: white;
      cursor: pointer;
      transition: all 0.3s;
      font-weight: 500;
  }

  .social-btn.google:hover {
      border-color: #DB4437;
      color: #DB4437;
  }

  .social-btn.facebook:hover {
      border-color: #4267B2;
      color: #4267B2;
  }

  .auth-switch {
      text-align: center;
      color: #666;
  }

  .auth-switch a {
      color: var(--sleepsure-blue);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
  }

  .auth-switch a:hover {
      color: #153a73;
  }

  /* Form States */
  #otp-form {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      padding: var(--spacing-xl);
      display: flex;
      flex-direction: column;
      justify-content: center;
      transform: translateX(100%);
      transition: transform 0.5s ease;
  }

  .auth-forms.otp-active #phone-form {
      transform: translateX(-100%);
  }

  .auth-forms.otp-active #otp-form {
      transform: translateX(0);
  }



  /* Responsive Design */
  @media (max-width: 768px) {
      .auth-container {
          flex-direction: column;
          height: auto;
      }

      .auth-image {
          padding: var(--spacing-lg);
          min-height: 200px;
      }

      .auth-image-content {
          max-width: 100%;
      }

      .header-container {
          /* flex-direction: column; */
          gap: var(--spacing-md);
      }

      nav ul {
          justify-content: center;
          flex-wrap: wrap;
      }

      .social-login {
          flex-direction: column;
      }

      .otp-input-container {
          justify-content: center;
      }
  }

  /* login page end */


  /* signup page start */

  .page-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      padding: 40px 20px;
  }

  .content-container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
  }

  .grid-row {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -15px;
  }

  .grid-half {
      flex: 0 0 100%;
      padding: 15px;
  }

  @media (min-width: 768px) {
      .grid-half {
          flex: 0 0 50%;
      }
  }

  .account-panel {
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      height: 100%;
  }

  .brand-section {
      background: linear-gradient(rgb(208 220 239 / 90%), rgba(27, 78, 155, 0.8)), url(https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80);
      background-size: cover;
      background-position: center;
      color: white;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
  }

  .form-section {
      padding: 50px 40px;
  }

  .brand-logo {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 30px;
      display: flex;
      align-items: center;
      gap: 10px;
  }

  .welcome-content h1 {
      font-size: 2.2rem;
      margin-bottom: 15px;
      font-weight: 700;
      color: white;
  }

  .welcome-content p {
      font-size: 1.1rem;
      opacity: 0.9;
      line-height: 1.6;
  }

  .benefits-list {
      margin-top: 30px;
  }

  .benefit-item {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 15px;
  }


  .form-header {
      margin-bottom: 30px;
  }

  .form-heading {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--sleepsure-blue);
      margin-bottom: 5px;
  }

  .form-description {
      color: #666;
  }

  .input-row {
      display: flex;
      flex-wrap: wrap;
      margin: 0 -10px;
  }

  .input-half {
      flex: 0 0 100%;
      padding: 0 10px;
  }

  @media (min-width: 576px) {
      .input-half {
          flex: 0 0 50%;
      }
  }

  .field-group {
      margin-bottom: 20px;
  }

  .field-label {
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 8px;
      display: block;
      text-align: left;
  }

  .field-input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s;
  }

  .field-input:focus {
      outline: none;
      border-color: var(--sleepsure-blue);
      box-shadow: 0 0 0 3px rgba(27, 78, 155, 0.1);
  }

  .password-container {
      position: relative;
  }

  .password-toggle {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #666;
      cursor: pointer;
  }

  .checkbox-container {
      margin-bottom: 20px;
  }

  .checkbox-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: 15px;
  }

  .checkbox-input {
      margin-top: 3px;
  }

  .checkbox-text {
      color: #666;
      line-height: 1.4;
  }

  .checkbox-text a {
      color: var(--sleepsure-blue);
      text-decoration: none;
      font-weight: 500;
  }

  .checkbox-text a:hover {
      text-decoration: underline;
  }

  .submit-button {
      width: 100%;
      background: var(--sleepsure-green);
      color: white;
      border: none;
      padding: 14px;
      border-radius: 8px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      margin-bottom: 20px;
  }

  .submit-button:hover {
      background: #36852f;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(66, 158, 57, 0.3);
  }

  .submit-button:disabled {
      background: #cccccc;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
  }

  .separator {
      text-align: center;
      margin: 25px 0;
      position: relative;
  }

  .separator::before {
      /* content: ''; */
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 1px;
      background: #e0e0e0;
  }

  .separator-text {
      background: white;
      padding: 0 15px;
      color: #666;
      font-size: 0.9rem;
  }

  .social-buttons {
      display: flex;
      gap: 15px;
      margin-bottom: 25px;
  }

  .social-button {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 12px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      background: white;
      cursor: pointer;
      transition: all 0.3s;
      font-weight: 500;
  }

  .social-button:hover {
      border-color: var(--sleepsure-blue);
      color: var(--sleepsure-blue);
      transform: translateY(-2px);
  }

  .auth-link {
      text-align: center;
      color: #666;
  }

  .auth-link a {
      color: var(--sleepsure-blue);
      text-decoration: none;
      font-weight: 600;
  }

  .auth-link a:hover {
      text-decoration: underline;
  }

  /* Responsive adjustments */
  @media (max-width: 767px) {
      .brand-section {
          padding: 40px 30px;
      }

      .form-section {
          padding: 40px 30px;
      }

      .social-buttons {
          flex-direction: column;
      }
  }

  @media (max-width: 575px) {
      .page-wrapper {
          padding: 20px 15px;
      }

      .brand-section,
      .form-section {
          padding: 4px;
      }

      .welcome-content h1 {
          font-size: 1.8rem;
      }
  }


  /* signup page end */

  /* otp page start */
  .otp-main {
      color: var(--text-dark);
      line-height: 1.6;
      background: linear-gradient(135deg, var(--light-blue-bg) 0%, #f9f9f9 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      /* padding: var(--spacing-md); */
  }

  .otp-container {
      width: 100%;
      max-width: 450px;
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-heavy);
      overflow: hidden;
  }

  .otp-header {
      background: #daebef;
      color: white;
      padding: var(--spacing-xl);
      text-align: center;
      position: relative;
  }

  .back-btn {
      position: absolute;
      left: var(--spacing-xl);
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: white;
      font-size: 1.2rem;
      cursor: pointer;
      transition: opacity 0.3s;
  }

  .back-btn:hover {
      opacity: 0.8;
  }

  .logo {
      font-size: 1.5rem;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-sm);
  }

  .otp-content {
      padding: var(--spacing-xl);
  }

  .otp-title {
      font-size: 1.8rem;
      margin-bottom: var(--spacing-sm);
      color: var(--sleepsure-blue);
      text-align: center;
  }

  .otp-subtitle {
      text-align: center;
      color: #666;
      margin-bottom: var(--spacing-xl);
  }

  .phone-number {
      text-align: center;
      font-weight: 600;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-xl);
      font-size: 1.1rem;
  }

  .otp-inputs {
      display: flex;
      gap: var(--spacing-md);
      justify-content: center;
      margin-bottom: var(--spacing-xl);
  }

  .otp-input {
      width: 50px;
      height: 50px;
      text-align: center;
      font-size: 1.5rem;
      font-weight: bold;
      border: 2px solid #ddd;
      border-radius: var(--border-radius-md);
      transition: all 0.3s;
      background: white;
  }

  .otp-input:focus {
      outline: none;
      border-color: var(--sleepsure-blue);
      box-shadow: 0 0 0 3px rgba(27, 78, 155, 0.1);
      transform: translateY(-2px);
  }

  .otp-input.filled {
      border-color: var(--sleepsure-green);
      background-color: var(--light-green-bg);
  }

  .timer-section {
      text-align: center;
      margin-bottom: var(--spacing-lg);
  }

  .timer {
      font-size: 1rem;
      color: #666;
      margin-bottom: var(--spacing-md);
  }

  .countdown {
      font-weight: bold;
      color: var(--sleepsure-blue);
      font-size: 1.1rem;
  }

  .resend-otp {
      text-align: center;
      margin-bottom: var(--spacing-xl);
  }

  .resend-link {
      color: var(--sleepsure-blue);
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: var(--spacing-xs);
  }

  .resend-link:hover {
      color: #153a73;
      transform: translateY(-1px);
  }

  .resend-link.disabled {
      color: #999;
      cursor: not-allowed;
      transform: none;
  }

  .verify-btn {
      width: 100%;
      background-color: var(--sleepsure-green);
      color: white;
      border: none;
      padding: var(--spacing-lg) var(--spacing-xl);
      border-radius: var(--border-radius-md);
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 1.1rem;
      margin-bottom: var(--spacing-lg);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-sm);
  }

  .verify-btn:hover {
      background-color: #36852f;
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  .verify-btn:disabled {
      background-color: #cccccc;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
  }

  .help-text {
      text-align: center;
      color: #666;
      font-size: 0.9rem;
      margin-bottom: var(--spacing-lg);
  }

  .contact-support {
      text-align: center;
      margin-top: var(--spacing-xl);
      padding-top: var(--spacing-lg);
      border-top: 1px solid #eee;
  }

  .support-link {
      color: var(--sleepsure-blue);
      text-decoration: none;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      gap: var(--spacing-sm);
      transition: color 0.3s;
  }

  .support-link:hover {
      color: #153a73;
  }

  .success-message {
      background-color: var(--light-green-bg);
      border: 1px solid var(--sleepsure-green);
      color: var(--sleepsure-green);
      padding: var(--spacing-md);
      border-radius: var(--border-radius-md);
      text-align: center;
      margin-bottom: var(--spacing-lg);
      display: none;
  }

  .error-message {
      background-color: #ffe6e6;
      border: 1px solid var(--alert-red);
      color: var(--alert-red);
      padding: var(--spacing-md);
      border-radius: var(--border-radius-md);
      text-align: center;
      margin-bottom: var(--spacing-lg);
      display: none;
  }

  /* Animation for OTP input */
  @keyframes shake {

      0%,
      100% {
          transform: translateX(0);
      }

      25% {
          transform: translateX(-5px);
      }

      75% {
          transform: translateX(5px);
      }
  }

  .shake {
      animation: shake 0.5s ease-in-out;
  }

  /* Responsive Design */
  @media (max-width: 480px) {
      .otp-container {
          max-width: 100%;
      }

      .otp-inputs {
          gap: var(--spacing-sm);
      }

      .otp-input {
          width: 35px;
          height: 35px;
          font-size: 1.3rem;
      }

      .otp-content {
          padding: var(--spacing-lg);
      }

      .otp-header {
          padding: var(--spacing-lg);
      }
  }

  /* otp page end */

  /* about page start */

  .about-container {

      padding: var(--spacing-xxl) var(--spacing-lg);
  }

  .page-title {
      text-align: center;
      margin-bottom: var(--spacing-xxl);
      color: var(--sleepsure-blue);
      font-size: 3rem;
      font-weight: 700;
      position: relative;
      padding-bottom: var(--spacing-md);
  }

  .page-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: var(--sleepsure-blue);
      border-radius: 2px;
  }

  .section-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: var(--spacing-xl);
      align-items: center;
  }

  .text-content p {
      margin-bottom: var(--spacing-md);
      color: #555;
      font-size: 1.05rem;
      text-align: justify;
  }

  .image-content {
      position: relative;
      border-radius: var(--border-radius-md);
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);

  }

  .image-content img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
  }

  .image-content:hover img {
      transform: scale(1.05);
  }

  /* about page end */

  /* terms and conditions page start */

  /* Last Updated */
  .last-updated {
      text-align: center;
      margin-bottom: var(--spacing-lg);
      color: #64748b;
      font-style: italic;
  }

  /* Terms Container */
  .terms-container {
      background: white;
      border: 1px solid #e2e8f0;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xxl);
      box-shadow: var(--shadow-light);
      margin-bottom: var(--spacing-xl);
  }

  /* Table of Contents */
  .toc {
      background-color: var(--light-blue-bg);
      border-radius: var(--border-radius-md);
      padding: var(--spacing-lg);
      margin-bottom: var(--spacing-xl);
  }

  .toc h3 {
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-md);
  }

  .toc ul {
      list-style-type: none;
  }

  .toc li {
      margin-bottom: var(--spacing-sm);
  }

  .toc a {
      color: var(--text-dark);
      text-decoration: none;
      transition: color 0.3s ease;
      display: flex;
      align-items: center;
  }

  .toc a:hover {
      color: var(--sleepsure-blue);
  }

  .toc i {
      margin-right: var(--spacing-sm);
      color: var(--sleepsure-blue);
      font-size: 0.9rem;
  }

  /* terms-section Styles */
  .terms-section {
      margin-bottom: var(--spacing-xl);
  }

  .terms-section-title {
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-md);
      padding-bottom: var(--spacing-xs);
      border-bottom: 1px solid #e2e8f0;
      font-size: 1.4rem;
  }

  .terms-section-content {
      margin-bottom: var(--spacing-lg);
  }

  .terms-section-content p {
      margin-bottom: var(--spacing-md);
      text-align: justify;
  }

  .highlight {
      background-color: var(--light-green-bg);
      padding: var(--spacing-md);
      border-left: 4px solid var(--sleepsure-green);
      border-radius: var(--border-radius-sm);
      margin: var(--spacing-md) 0;
  }

  /* List Styles */
  .terms-list {
      list-style-type: none;
      margin: var(--spacing-md) 0;
  }

  .terms-list li {
      margin-bottom: var(--spacing-sm);
      padding-left: var(--spacing-lg);
      position: relative;
  }

  .terms-list li:before {
      content: "•";
      color: var(--sleepsure-blue);
      font-weight: bold;
      position: absolute;
      left: 0;
  }

  /* Footer Actions */
  .footer-actions {
      display: flex;
      justify-content: space-between;
      margin-top: var(--spacing-xl);
      padding-top: var(--spacing-lg);
      border-top: 1px solid #e2e8f0;
  }

  .btn {
      padding: var(--spacing-md) var(--spacing-lg);
      border: none;
      border-radius: var(--border-radius-md);
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: var(--spacing-xs);
  }

  .btn-primary {
      background-color: var(--sleepsure-blue);
      color: white;
  }

  .btn-primary:hover {
      background-color: #153a75;
  }

  .btn-outline {
      background-color: transparent;
      border: 1px solid #cbd5e1;
      color: var(--text-dark);
  }

  .btn-outline:hover {
      background-color: #f1f5f9;
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
      .terms-container {
          padding: var(--spacing-lg);
      }

      .footer-actions {
          flex-direction: column;
          gap: var(--spacing-md);
      }

      .footer-actions .btn {
          width: 100%;
          justify-content: center;
      }

      .page-title {
          font-size: 1.8rem;
      }
  }

  /* terms and conditions page end */

  /* career page start */
  /* Hero Section */
  .hero-section {
      display: flex;
      align-items: center;
      gap: var(--spacing-xl);
      margin-bottom: var(--spacing-xxl);
  }

  .hero-content {
      flex: 1;
  }

  .hero-image {
      flex: 1;
      border-radius: var(--border-radius-lg);
      overflow: hidden;
      box-shadow: var(--shadow-medium);
  }

  .hero-image img {
      width: 100%;
      height: auto;
      display: block;
  }

  .hero-title {
      font-size: 2rem;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-lg);
  }

  .hero-description {
      margin-bottom: var(--spacing-lg);
      font-size: 1.1rem;
  }

  /* Stats Section */
  .stats-section {
      background-color: var(--light-blue-bg);
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      margin-bottom: var(--spacing-xxl);
  }

  .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: var(--spacing-xl);
      text-align: center;
  }

  .stat-item {
      padding: var(--spacing-lg);
  }

  .stat-number {
      font-size: 2.5rem;
      font-weight: bold;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-xs);
  }

  .stat-label {
      color: #64748b;
      font-weight: 600;
  }

  /* Benefits Section */
  .benefits-section {
      margin-bottom: var(--spacing-xxl);
  }

  .section-title {
      text-align: center;
      font-size: 2rem;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-xl);
  }

  .benefits-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: var(--spacing-xl);
  }

  .benefit-card {
      background: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      box-shadow: var(--shadow-light);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-align: center;
  }

  .benefit-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-heavy);
  }


  .benefit-icon i {
      font-size: 2rem;
      color: var(--sleepsure-green);
  }

  .benefit-title {
      font-size: 1.3rem;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-md);
  }

  /* Jobs Section */
  .jobs-section {
      margin-bottom: var(--spacing-xxl);
  }

  .jobs-filter {
      display: flex;
      gap: var(--spacing-md);
      margin-bottom: var(--spacing-xl);
      flex-wrap: wrap;
  }

  .filter-btn {
      padding: var(--spacing-sm) var(--spacing-lg);
      background: white;
      border: 1px solid #e2e8f0;
      border-radius: var(--border-radius-md);
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
  }

  .filter-btn:hover,
  .filter-btn.active {
      background-color: var(--sleepsure-blue);
      color: white;
      border-color: var(--sleepsure-blue);
  }

  .jobs-grid {
      display: grid;
      gap: var(--spacing-lg);
  }

  .job-card {
      background: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      box-shadow: var(--shadow-light);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-left: 4px solid var(--sleepsure-blue);
  }

  .job-card:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-medium);
  }

  .job-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: var(--spacing-md);
  }

  .job-title {
      font-size: 1.4rem;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-xs);
  }

  .job-meta {
      display: flex;
      gap: var(--spacing-lg);
      margin-bottom: var(--spacing-md);
      flex-wrap: wrap;
  }

  .job-meta-item {
      display: flex;
      align-items: center;
      gap: var(--spacing-xs);
      color: #64748b;
  }

  .job-meta-item i {
      color: var(--sleepsure-blue);
  }

  .job-description {
      margin-bottom: var(--spacing-lg);
  }

  .job-tags {
      display: flex;
      gap: var(--spacing-sm);
      flex-wrap: wrap;
      margin-bottom: var(--spacing-lg);
  }

  .job-tag {
      background-color: var(--light-blue-bg);
      color: var(--sleepsure-blue);
      padding: var(--spacing-xs) var(--spacing-sm);
      border-radius: var(--border-radius-sm);
      font-size: 0.9rem;
      font-weight: 600;
  }

  .btn {
      padding: var(--spacing-md) var(--spacing-lg);
      border: none;
      border-radius: var(--border-radius-md);
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: var(--spacing-sm);
      text-decoration: none;
  }

  .btn-primary {
      background-color: var(--sleepsure-blue);
      color: white;
  }

  .btn-primary:hover {
      background-color: #153a75;
      transform: translateY(-2px);
  }

  .btn-outline {
      background-color: transparent;
      border: 1px solid var(--sleepsure-blue);
      color: var(--sleepsure-blue);
  }

  .btn-outline:hover {
      background-color: var(--light-blue-bg);
  }

  /* Culture Section */
  .culture-section {
      background: linear-gradient(135deg, #1b4e9b 0%, #2c6cc4 100%);
      color: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xxl);
      margin-bottom: var(--spacing-xxl);
      text-align: center;
  }

  .culture-title {
      font-size: 2rem;
      margin-bottom: var(--spacing-lg);
  }

  .culture-description {
      max-width: 800px;
      margin: 0 auto var(--spacing-xl);
      font-size: 1.1rem;
  }

  .culture-features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: var(--spacing-xl);
      margin-top: var(--spacing-xl);
  }

  .culture-feature {
      padding: var(--spacing-lg);
  }

  .culture-feature i {
      font-size: 2.5rem;
      margin-bottom: var(--spacing-md);
      color: rgba(255, 255, 255, 0.9);
  }

  .culture-feature h3 {
      margin-bottom: var(--spacing-sm);
      font-size: 1.3rem;
  }

  /* Application Process */
  .process-section {
      margin-bottom: var(--spacing-xxl);
  }

  .process-steps {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: var(--spacing-lg);
      margin-top: var(--spacing-xl);
  }

  .process-step {
      flex: 1;
      min-width: 200px;
      text-align: center;
      padding: var(--spacing-lg);
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-light);
  }

  .step-number {
      width: 60px;
      height: 60px;
      background-color: var(--sleepsure-blue);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto var(--spacing-md);
      font-weight: bold;
      font-size: 1.5rem;
  }

  .step-title {
      font-weight: 600;
      margin-bottom: var(--spacing-sm);
      color: var(--sleepsure-blue);
      font-size: 1.2rem;
  }

  /* CTA Section */
  .cta-section {
      text-align: center;
      padding: var(--spacing-xxl);
      background-color: var(--light-green-bg);
      border-radius: var(--border-radius-lg);
      margin-bottom: var(--spacing-xl);
  }

  .cta-title {
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-md);
      font-size: 2rem;
  }

  .cta-description {
      margin-bottom: var(--spacing-lg);
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      font-size: 1.1rem;
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
      .hero-section {
          flex-direction: column;
          display: none;
      }

      .job-header {
          flex-direction: column;
          gap: var(--spacing-md);
      }

      .jobs-filter {
          justify-content: center;
      }

      .process-steps {
          flex-direction: column;
      }

      .page-title {
          font-size: 2rem;
      }
  }

  /* career page end */

  /* wishlist page start */

  .wishlist-stats {
      display: flex;
      gap: var(--spacing-lg);
  }

  .stat {
      text-align: center;
  }

  .stat-number {
      font-size: 1.5rem;
      font-weight: bold;
      color: var(--sleepsure-blue);
  }

  .stat-label {
      color: #64748b;
      font-size: 0.9rem;
  }

  /* Wishlist Items */
  .wishlist-items {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-lg);
  }

  .wishlist-item {
      display: flex;
      align-items: center;
      background: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-lg);
      box-shadow: var(--shadow-light);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .wishlist-item:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  .item-image {
      width: 120px;
      height: 120px;
      border-radius: var(--border-radius-md);
      overflow: hidden;
      flex-shrink: 0;
  }

  .item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
  }

  .item-details {
      flex: 1;
      padding: 0 var(--spacing-lg);
  }

  .item-category {
      color: #64748b;
      font-size: 0.85rem;
      text-transform: uppercase;
      margin-bottom: var(--spacing-xs);
  }

  .item-title {
      font-weight: 600;
      margin-bottom: var(--spacing-sm);
      font-size: 1.1rem;
  }

  .item-price {
      font-weight: bold;
      color: var(--sleepsure-blue);
      font-size: 1.2rem;
  }

  .old-price {
      text-decoration: line-through;
      color: #94a3b8;
      font-size: 1rem;
      margin-left: var(--spacing-xs);
  }

  .item-actions {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-sm);
  }

  .btn {
      padding: var(--spacing-md) var(--spacing-lg);
      border: none;
      border-radius: var(--border-radius-md);
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--spacing-xs);
  }

  .btn-primary {
      background-color: var(--sleepsure-blue);
      color: white;
  }

  .btn-primary:hover {
      background-color: #153a75;
  }

  .btn-success {
      background-color: var(--sleepsure-green);
      color: white;
  }

  .btn-success:hover {
      background-color: #37832f;
  }

  .btn-outline {
      background-color: transparent;
      border: 1px solid #cbd5e1;
      color: var(--text-dark);
  }

  .btn-outline:hover {
      background-color: #f1f5f9;
  }

  .btn-danger {
      background-color: transparent;
      border: 1px solid #fecaca;
      color: #dc2626;
  }

  .btn-danger:hover {
      background-color: #fef2f2;
  }

  .sale-badge {
      background-color: var(--sleepsure-green);
      color: white;
      padding: var(--spacing-xs) var(--spacing-sm);
      border-radius: var(--border-radius-sm);
      font-size: 0.8rem;
      font-weight: 600;
      display: inline-block;
      margin-left: var(--spacing-sm);
  }

  /* Empty State */
  .empty-wishlist {
      text-align: center;
      padding: var(--spacing-xxl);
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-light);
      margin-top: var(--spacing-xl);
  }

  .empty-wishlist i {
      font-size: 4rem;
      color: #cbd5e1;
      margin-bottom: var(--spacing-lg);
  }

  .empty-wishlist h3 {
      color: #64748b;
      margin-bottom: var(--spacing-md);
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
      .wishlist-item {
          flex-direction: column;
          text-align: center;
          gap: var(--spacing-md);
      }

      .item-details {
          padding: 0;
      }

      .item-actions {
          flex-direction: row;
          width: 100%;
      }

      .item-actions .btn {
          flex: 1;
      }

      .page-header {
          flex-direction: column;
          gap: var(--spacing-md);
          align-items: flex-start;
      }

      .wishlist-stats {
          width: 100%;
          justify-content: space-between;
      }
  }

  /* wishlist page end */


  /* guaranty page  start*/
  /* Hero Banner */
  .hero-banner {
      background: linear-gradient(135deg, var(--sleepsure-blue) 0%, #2c6cc4 100%);
      color: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xxl);
      text-align: center;
      margin-bottom: var(--spacing-xl);
      box-shadow: var(--shadow-medium);
  }

  .hero-banner h2 {
      font-size: 1.8rem;
      margin-bottom: var(--spacing-md);
  }

  .hero-banner p {
      font-size: 1.1rem;
      max-width: 700px;
      margin: 0 auto;
  }

  /* Guarantees Container */
  .guarantees-container {
      background: white;
      border: 1px solid #e2e8f0;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xxl);
      box-shadow: var(--shadow-light);
      margin-bottom: var(--spacing-xl);
  }

  /* Guarantee Cards Grid */
  .guarantees-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: var(--spacing-xl);
      margin-bottom: var(--spacing-xl);
  }

  .guarantee-card {
      background: white;
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      box-shadow: var(--shadow-light);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-top: 4px solid var(--sleepsure-blue);
      height: 100%;
      display: flex;
      flex-direction: column;
  }

  .guarantee-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-heavy);
  }

  .guarantee-icon {
      width: 70px;
      height: 70px;
      background-color: var(--light-blue-bg);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: var(--spacing-lg);
  }

  .guarantee-icon i {
      font-size: 1.8rem;
      color: var(--sleepsure-blue);
  }

  .guarantee-title {
      font-size: 1.4rem;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-md);
  }

  .guarantee-description {
      margin-bottom: var(--spacing-lg);
      flex-grow: 1;
  }

  .guarantee-details {
      background-color: #f8fafc;
      border-radius: var(--border-radius-md);
      padding: var(--spacing-md);
      margin-top: auto;
  }

  .guarantee-details h4 {
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-sm);
      font-size: 1rem;
  }

  .guarantee-details ul {
      list-style-type: none;
      margin: 0;
  }

  .guarantee-details li {
      margin-bottom: var(--spacing-xs);
      padding-left: var(--spacing-md);
      position: relative;
  }

  .guarantee-details li:before {
      content: "✓";
      color: var(--sleepsure-green);
      font-weight: bold;
      position: absolute;
      left: 0;
  }

  /* How It Works */
  .how-it-works {
      background-color: var(--light-blue-bg);
      border-radius: var(--border-radius-lg);
      padding: var(--spacing-xl);
      margin-bottom: var(--spacing-xl);
  }

  .how-it-works h2 {
      text-align: center;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-xl);
  }

  .steps {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: var(--spacing-lg);
  }

  .step {
      flex: 1;
      min-width: 200px;
      text-align: center;
      padding: var(--spacing-lg);
  }

  .step-number {
      width: 50px;
      height: 50px;
      background-color: var(--sleepsure-blue);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto var(--spacing-md);
      font-weight: bold;
      font-size: 1.2rem;
  }

  .step-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: var(--spacing-sm);
      color: var(--sleepsure-blue);
  }

  /* FAQ Section */
  .faq-section {
      margin-bottom: var(--spacing-xl);
  }

  .faq-section h2 {
      text-align: center;
      color: var(--sleepsure-blue);
      margin-bottom: var(--spacing-xl);
  }

  .faq-item {
      margin-bottom: var(--spacing-md);
      border: 1px solid #e2e8f0;
      border-radius: var(--border-radius-md);
      overflow: hidden;
  }

  .faq-question {
      background-color: #f8fafc;
      padding: var(--spacing-lg);
      font-weight: 600;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
  }

  .faq-question:hover {
      background-color: #f1f5f9;
  }

  .faq-answer {
      padding: var(--spacing-lg);
      background-color: white;
      display: none;
  }

  .faq-item.active .faq-answer {
      display: block;
  }

  .faq-toggle {
      color: var(--sleepsure-blue);
      font-size: 1.2rem;
  }

  /* CTA Section */
  .cta-section {
      text-align: center;
      padding: var(--spacing-xxl);
      background: linear-gradient(135deg, var(--sleepsure-green) 0%, #5cb850 100%);
      color: white;
      border-radius: var(--border-radius-lg);
      margin-bottom: var(--spacing-xl);
  }

  .cta-section h2 {
      margin-bottom: var(--spacing-md);
      font-size: 1.8rem;
  }

  .cta-section p {
      margin-bottom: var(--spacing-lg);
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
  }

  .btn {
      padding: var(--spacing-sm) var(--spacing-xl);
      border: none;
      border-radius: var(--border-radius-md);
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: var(--spacing-sm);
      font-size: 1.1rem;
  }

  .btn-primary {
      background-color: white;
      color: var(--sleepsure-green);
  }

  .btn-primary:hover {
      background-color: #f8fafc;
      transform: translateY(-2px);
      box-shadow: var(--shadow-medium);
  }

  /* Responsive Styles */
  @media (max-width: 768px) {
      .guarantees-container {
          padding: var(--spacing-lg);
      }

      .guarantees-grid {
          grid-template-columns: 1fr;
      }

      .steps {
          flex-direction: column;
      }

      .hero-banner {
          padding: var(--spacing-xl);
      }

      .page-title {
          font-size: 1.8rem;
      }
  }

  /* guaranty page  end*/

  /* category page start */
  /* Main Content */


  /* Filter Sidebar */
  .filter-sidebar {
      flex: 0 0 280px;
      background-color: var(--light-blue-bg);
      padding: var(--spacing-lg);
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-light);
      height: fit-content;
      position: sticky;
      top: 0px;
  }

  .filter-group {
      margin-bottom: var(--spacing-lg);
      border-bottom: 1px solid #eee;
      padding-bottom: var(--spacing-md);
  }

  .filter-group:last-child {
      border-bottom: none;
  }

  .filter-group h3 {
      margin-bottom: var(--spacing-md);
      font-size: 1.2rem;
      color: var(--sleepsure-blue);
  }

  .filter-options {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-sm);
  }

  .filter-option {
      display: flex;
      align-items: center;
  }

  .filter-option input {
      margin-right: var(--spacing-sm);
  }

  .filter-option label {
      cursor: pointer;
  }

  .price-range {
      display: flex;
      flex-direction: column;
      gap: var(--spacing-sm);
  }

  .price-inputs {
      display: flex;
      gap: var(--spacing-sm);
  }

  .price-inputs input {
      width: 100%;
      padding: var(--spacing-sm);
      border: 1px solid #ddd;
      border-radius: var(--border-radius-sm);
  }

  .apply-filters {
      background-color: var(--sleepsure-blue);
      color: white;
      border: none;
      padding: var(--spacing-md) var(--spacing-lg);
      border-radius: var(--border-radius-md);
      cursor: pointer;
      font-weight: 600;
      width: 100%;
      margin-top: var(--spacing-md);
      transition: background-color 0.3s;
  }

  .apply-filters:hover {
      background-color: #153a75;
  }

  /* Products Section */
  .products-section {
      flex: 1;
  }

  .sort-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    /* margin-bottom: var(--spacing-lg); */
    background-color: var(--sleepsure-green);
    padding: var(--spacing-md);
    /* border-radius: var(--border-radius-md); */
    box-shadow: var(--shadow-light);
}

  .results-count {
      font-weight: 500;
  }

  .sort-options {
      display: flex;
      align-items: center;
      gap: var(--spacing-sm);
  }

  .sort-options select {
      padding: var(--spacing-sm);
      border: 1px solid #ddd;
      border-radius: var(--border-radius-sm);
  }

  .view-options {
      display: flex;
      gap: var(--spacing-sm);
  }

  .view-btn {
      background: none;
      border: 1px solid #ddd;
      padding: var(--spacing-sm);
      border-radius: var(--border-radius-sm);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .view-btn.active {
      background-color: var(--sleepsure-blue);
      color: white;
      border-color: var(--sleepsure-blue);
  }



  /* Pagination */
  .pagination {
      display: flex;
      justify-content: center;
      margin-top: var(--spacing-xl);
      gap: var(--spacing-sm);
  }

  .pagination a,
  .pagination span {
      padding: var(--spacing-sm) var(--spacing-md);
      border: 1px solid #ddd;
      border-radius: var(--border-radius-sm);
      text-decoration: none;
      color: var(--text-dark);
  }

  .pagination a:hover,
  .pagination a.active {
      background-color: var(--sleepsure-blue);
      color: white;
      border-color: var(--sleepsure-blue);
  }

  /* Mobile Responsive Styles */
  @media (max-width: 992px) {
      .main-content {
          flex-direction: column;
      }

      .filter-sidebar {
          width: 100%;
          position: static;
      }

  }

  @media (max-width: 480px) {
      .products-grid {
          grid-template-columns: 1fr;
      }

      .price-inputs {
          flex-direction: column;
      }
  }

  @media (max-width: 768px) {


      .mobile-menu-btn {
          display: block;
      }

      .sort-bar {
          flex-direction: column;
          gap: var(--spacing-md);
          align-items: flex-start;
      }

      .view-options {
          align-self: flex-end;
      }

      .products-grid {
          grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      }
  }

  /* category page end */

  /* ======================================= */
  /* BLOG LIST STYLES */
  /* ======================================= */

  /* Main Container and Layout */
  .blog-list-page {
      padding: var(--spacing-xxl) var(--spacing-lg);
      /* 40px Top/Bottom, 20px Left/Right */
      max-width: 1200px;
      margin: 0 auto;
  }

  .page-title {
      color: var(--sleepsure-blue);
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: var(--spacing-xxl);
      text-align: center;
  }

  /* Blog Grid Layout - Adjusted for 3 Cards */
  .blog-grid {
      display: grid;
      /* Force 3 columns on large screens for a clean look */
      grid-template-columns: repeat(3, 1fr);
      gap: var(--spacing-xl);
  }

  /* Responsiveness for smaller screens */
  @media (max-width: 1024px) {
      .blog-grid {
          grid-template-columns: repeat(2, 1fr);
          /* 2 columns on tablets */
      }
  }

  @media (max-width: 600px) {
      .blog-grid {
          grid-template-columns: 1fr;
          /* Single column on mobile */
      }
  }


  /* --- Blog Card Styling (No Change) --- */

  .blog-card {
      background-color: var(--text-light);
      border-radius: var(--border-radius-lg);
      box-shadow: var(--shadow-medium);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .blog-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-heavy);
  }

  .blog-card-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
  }

  .blog-card-content {
      padding: var(--spacing-md);
  }

  .blog-card-category {
      display: inline-block;
      background-color: var(--light-blue-bg);
      color: var(--sleepsure-blue);
      font-size: 0.8rem;
      font-weight: 600;
      padding: var(--spacing-xs) var(--spacing-sm);
      border-radius: var(--border-radius-sm);
      margin-bottom: var(--spacing-sm);
      text-transform: uppercase;
  }

  .blog-card-title {
      font-size: 1.3rem;
      color: var(--text-dark);
      margin-bottom: var(--spacing-sm);
      line-height: 1.4;
      font-weight: 600;
  }

  .blog-card-excerpt {
      font-size: 0.95rem;
      color: #666;
      margin-bottom: var(--spacing-md);
  }

  .blog-card-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.85rem;
      color: #888;
      padding-top: var(--spacing-sm);
      border-top: 1px solid #eee;
  }

  .read-more-link {
      color: var(--sleepsure-green);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s;
  }

  .read-more-link:hover {
      color: var(--sleepsure-blue);
  }

  /* bulk order page start */
  /* Bulk Quote Page Styles */
        .bulk-container {
            max-width: 1200px;
            margin: var(--spacing-xxl) auto;

            border-radius: var(--border-radius-lg);

            color: var(--text-dark);
            font-family: "Inter", Arial, sans-serif;
        }

       
        /* ===========================
   FORM SECTION
   =========================== */
        .bulk-form-section {
            background: #fff;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-light);
            padding: var(--spacing-xl);
            margin-bottom: var(--spacing-xxl);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--spacing-lg);
        }

        /* Form Labels & Inputs */
        .form-label {
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
            display: block;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: var(--spacing-sm) var(--spacing-md);
            border: 1px solid #ccc;
            border-radius: var(--border-radius-md);
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--sleepsure-blue);
            box-shadow: 0 0 0 3px rgba(27, 78, 155, 0.2);
        }

        /* Textarea */
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        /* Full Width Field */
        .form-full {
            grid-column: 1 / -1;
        }

        /* Button Styles */
        .btn-primary {
            background: var(--sleepsure-blue);
            color: var(--text-light);
            padding: var(--spacing-md);
            border: none;
            border-radius: var(--border-radius-md);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: var(--shadow-light);
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background: #163e7d;
            transform: translateY(-2px);
        }

        /* ===========================
   CTA SECTION
   =========================== */
        .cta-section {
            background: var(--light-green-bg);
            text-align: center;
            padding: var(--spacing-xxl) var(--spacing-lg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-light);
        }

        .cta-title {
            color: var(--sleepsure-green);
            font-size: 1.8rem;
            margin-bottom: var(--spacing-md);
            font-weight: 700;
        }

        .cta-section p {
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: var(--spacing-lg);
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: var(--spacing-md);
        }

        /* CTA Buttons */
        .btn-secondary {
            background: transparent;
            color: var(--sleepsure-green);
            padding: var(--spacing-md);
            border: 2px solid var(--sleepsure-green);
            border-radius: var(--border-radius-md);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: var(--sleepsure-green);
            color: var(--text-light);
            transform: translateY(-2px);
        }

        /* CTA small info (response time) */
        .cta-section i {
            color: var(--sleepsure-green);
            margin-right: 6px;
        }

        /* Responsive */
        @media (max-width: 768px) {


            .section-title,
            .cta-title {
                font-size: 1.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
  /* bulk order page end */

  /* faq page start */
  .faq-container {

  margin: var(--spacing-xxl) auto;
  padding: var(--spacing-xl);
  background: var(--light-blue-bg);
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-medium);
  font-family: "Inter", Arial, sans-serif;
  color: var(--text-dark);
}

/* Header Section */
.faq-header {
  text-align: center;
  margin-bottom: var(--spacing-xxl);
}

.page-title {
  font-size: 2rem;
  color: var(--sleepsure-blue);
  font-weight: 700;
  margin-bottom: var(--spacing-sm);
}

.page-subtitle {
  font-size: 1.05rem;
  color: #555;
  line-height: 1.6;
}

/* ===============================
   CATEGORY BUTTONS
   =============================== */
.faq-categories {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: var(--spacing-sm);
  margin-bottom: var(--spacing-xl);
}

.category-btn {
  background: #fff;
  color: var(--sleepsure-blue);
  border: 1px solid var(--sleepsure-blue);
  padding: var(--spacing-sm) var(--spacing-md);
  border-radius: var(--border-radius-md);
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: var(--shadow-light);
}

.category-btn:hover {
  background: var(--sleepsure-blue);
  color: var(--text-light);
}

.category-btn.active {
  background: var(--sleepsure-blue);
  color: var(--text-light);
  box-shadow: 0 4px 10px rgba(27, 78, 155, 0.2);
}

/* ===============================
   ACCORDION SECTION
   =============================== */
.accordion {
  background: #fff;
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-light);
  overflow: hidden;
}

/* Accordion Items */
.accordion-item {
  border-bottom: 1px solid #eee;
}

.accordion-item:last-child {
  border-bottom: none;
}

/* Accordion Buttons */
.accordion-button {
  display: flex;
  align-items: center;
  width: 100%;
  background: #fff;
  color: var(--text-dark);
  font-weight: 600;
  padding: var(--spacing-md) var(--spacing-lg);
  text-align: left;
  border: none;
  border-radius: 0;
  font-size: 1rem;
  transition: all 0.3s ease;
}

.accordion-button.collapsed {
  background: #f9f9f9;
}

.accordion-button:hover {
  background: #f0f6ff;
}

.accordion-button:focus {
  outline: none;
  box-shadow: none;
}

/* Icon beside question */
.faq-icon {
  width: 36px;
  height: 36px;
  background: var(--light-blue-bg);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--sleepsure-blue);
  margin-right: var(--spacing-md);
  flex-shrink: 0;
  font-size: 1.1rem;
}

/* Accordion Body */
.accordion-body {
  background: #fff;
  color: #555;
  font-size: 0.97rem;
  line-height: 1.7;
  padding: var(--spacing-md) var(--spacing-lg) var(--spacing-lg);
}

.accordion-body strong {
  color: var(--sleepsure-blue);
}

.accordion-body .highlight {
  background: var(--light-blue-bg);
  color: var(--sleepsure-blue);
  padding: 2px 6px;
  border-radius: 4px;
  font-weight: 600;
}

/* ===============================
   CONTACT SUPPORT SECTION
   =============================== */
.contact-section {
  text-align: center;
  margin-top: var(--spacing-xxl);
  background: var(--light-green-bg);
  padding: var(--spacing-xxl) var(--spacing-lg);
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-light);
}

.contact-title {
  font-size: 1.6rem;
  color: var(--sleepsure-green);
  font-weight: 700;
  margin-bottom: var(--spacing-sm);
}

.contact-section p {
  color: #444;
  margin-bottom: var(--spacing-lg);
  font-size: 1rem;
}

/* Contact Button */
.contact-btn {
  background: var(--sleepsure-green);
  color: var(--text-light);
  border: none;
  padding: var(--spacing-md) var(--spacing-xl);
  border-radius: var(--border-radius-md);
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: var(--shadow-light);
}

.contact-btn i {
  margin-right: 8px;
}

.contact-btn:hover {
  background: #368330;
  transform: translateY(-2px);
}

/* ===============================
   RESPONSIVE DESIGN
   =============================== */
@media (max-width: 768px) {
  .faq-container {
    padding: var(--spacing-lg);
  }

  .page-title {
    font-size: 1.6rem;
  }

  .accordion-button {
    font-size: 0.95rem;
    padding: var(--spacing-md);
  }

  .faq-icon {
    width: 30px;
    height: 30px;
    font-size: 1rem;
  }

  .contact-btn {
    width: 100%;
  }
}
  /* faq page end */

  /* contact page start    */
  .contact-container {

  margin: var(--spacing-xxl) auto;
  padding: var(--spacing-xl);
  background: #f9fbff;
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-medium);
  font-family: "Inter", Arial, sans-serif;
  color: var(--text-dark);
}

/* ===============================
   HEADER SECTION
   =============================== */
.contact-header {
  text-align: center;
  margin-bottom: var(--spacing-xxl);
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: var(--sleepsure-blue, #1b4e9b);
  margin-bottom: var(--spacing-sm);
}

.page-subtitle {
  font-size: 1.05rem;
  color: #555;
  line-height: 1.6;
  max-width: 700px;
  margin: 0 auto;
}

/* ===============================
   GRID LAYOUT
   =============================== */
.contact-grid {
  display: grid;
  grid-template-columns: 1.2fr 1fr;
  gap: var(--spacing-xl);
}

@media (max-width: 992px) {
  .contact-grid {
    grid-template-columns: 1fr;
  }
}

/* ===============================
   FORM SECTION
   =============================== */
.contact-form-section {
  background: #fff;
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-light);
  padding: var(--spacing-xl);
}

.form-title {
  font-size: 1.4rem;
  font-weight: 700;
  color: var(--sleepsure-blue, #1b4e9b);
  margin-bottom: var(--spacing-lg);
}

.form-group {
  margin-bottom: var(--spacing-md);
}

.form-label {
  display: block;
  font-weight: 600;
  color: #333;
  margin-bottom: 6px;
}

.form-control {
  width: 100%;
  padding: 12px 14px;
  border: 1px solid #d9e3f0;
  border-radius: 8px;
  background: #fdfdfd;
  font-size: 1rem;
  transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
  border-color: var(--sleepsure-blue, #1b4e9b);
  box-shadow: 0 0 5px rgba(27, 78, 155, 0.15);
  outline: none;
}

textarea.form-control {
  height: 120px;
  resize: none;
}

/* Submit Button */
.submit-btn {
  background: var(--sleepsure-green, #3cae52);
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 12px 20px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: var(--spacing-sm);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: var(--shadow-light);
}

.submit-btn:hover {
  background: #2e8d41;
  transform: translateY(-2px);
}

/* ===============================
   CONTACT INFO SECTION
   =============================== */
.contact-info-section {
  display: flex;
  flex-direction: column;
  gap: var(--spacing-lg);
}

.info-card {
  background: #fff;
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-light);
  padding: var(--spacing-lg);
  transition: all 0.3s ease;
  border-left: 5px solid transparent;
}

.info-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-medium);
}

/* Icon Colors by Type */
.info-card.support {
  border-left-color: var(--sleepsure-blue, #1b4e9b);
}

.info-card.sales {
  border-left-color: var(--sleepsure-green, #3cae52);
}

.info-card.store {
  border-left-color: #f8c146;
}

/* Card Header */
.card-header {
  display: flex;
  align-items: center;
  margin-bottom: var(--spacing-md);
}

.card-icon {
  width: 50px;
  height: 50px;
  background: var(--light-blue-bg, #e8f1ff);
  border-radius: 50%;
  color: var(--sleepsure-blue, #1b4e9b);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  margin-right: var(--spacing-md);
}

.card-title {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--text-dark);
  margin-bottom: 2px;
}

/* Contact Details */
.contact-details {
  list-style: none;
  padding: 0;
  margin: 0 0 var(--spacing-md);
}

.contact-details li {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
  color: #555;
  font-size: 0.95rem;
}

.contact-details li i {
  color: var(--sleepsure-blue, #1b4e9b);
  margin-right: 10px;
  font-size: 1rem;
}

/* Business Hours */
.business-hours {
  background: #f9fbff;
  border-radius: 8px;
  padding: var(--spacing-sm) var(--spacing-md);
}

.hours-title {
  font-weight: 700;
  color: var(--sleepsure-blue, #1b4e9b);
  margin-bottom: 4px;
  font-size: 0.95rem;
}

/* ===============================
   MAP SECTION
   =============================== */
.map-section {
  background: #fff;
  border-radius: var(--border-radius-lg);
  box-shadow: var(--shadow-light);
  margin-top: var(--spacing-xxl);
  padding: var(--spacing-xl);
  text-align: center;
}

.map-header {
  margin-bottom: var(--spacing-md);
}

.map-title {
  font-size: 1.4rem;
  font-weight: 700;
  color: var(--sleepsure-blue, #1b4e9b);
}

.map-placeholder {
  background: var(--light-blue-bg, #eaf2ff);
  border-radius: 12px;
  padding: var(--spacing-xl);
  color: var(--sleepsure-blue, #1b4e9b);
  display: inline-block;
  margin-top: var(--spacing-sm);
  box-shadow: var(--shadow-light);
}

.map-icon {
  font-size: 2.2rem;
  margin-bottom: var(--spacing-sm);
  color: var(--sleepsure-blue, #1b4e9b);
}

/* ===============================
   RESPONSIVE
   =============================== */
@media (max-width: 768px) {
  .contact-container {
    padding: var(--spacing-lg);
  }

  .page-title {
    font-size: 1.7rem;
  }

  .form-title {
    font-size: 1.2rem;
  }

  .info-card {
    padding: var(--spacing-md);
  }

  .map-placeholder {
    padding: var(--spacing-lg);
  }
}
  /* contact page end    */






  /* new product detail page */
   /* ============ Breadcrumb ============ */
       .new-product-details .breadcrumb-nav {
            padding: 0 12px;
        }

       .new-product-details .breadcrumb-nav span {
            font-size: 9px !important;
            line-height: 110%;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--sleepsure-blue);
        }

        /* ============ Product Gallery ============ */
        .new-product-details .main-img-box {
            background: #f8f8f8;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            height: 400px;
            position: relative;
        }

        .new-product-details .main-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

       .new-product-details .arrow-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.7);
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            z-index: 10;
        }

       .new-product-details .arrow-btn.left { left: 15px; }
        .new-product-details .arrow-btn.right { right: 15px; }

        .new-product-details .thumb-gallery {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

       .new-product-details .thumb {
            width: 80px;
            height: 60px;
            border: 2px solid #eee;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
        }

        .new-product-details .thumb.active { border-color: var(--sleepsure-blue); }
        .new-product-details .thumb img { width: 100%; height: 100%; object-fit: cover; }

        /* ============ Product Info ============ */
        .new-product-details .product-heading {
            font-size: 22px;
            font-weight: 600 !important;
        }

        .new-product-details .product-price {
            font-size: 22px;
        }

        .new-product-details .bottom-text {
            height: 4px;
            width: 100%;
            background: linear-gradient(90deg, #407dc9 0%, rgba(64, 125, 201, 0) 100.55%), #ffffff;
            border-radius: 4px;
        }

        /* ============ Gift Banner ============ */
        .new-product-details .gift-banner {
            background: var(--light-blue-bg);
            padding: 15px;
            border-radius: var(--border-radius-md);
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .new-product-details .plus-sign {
            font-size: 24px;
            color: var(--sleepsure-blue);
            margin-right: 10px;
        }

        /* ============ Buttons & Tabs ============ */
       .new-product-details .btn-tab {
            flex: 1;
            border: 1px solid #ddd;
            background: #f9f9f9;
            color: #666;
            font-weight: 500;
        }

       .new-product-details .btn-tab.active {
            background: #94b7e5;
            color: white;
            border-color: #94b7e5;
        }

        .new-product-details .product-btn {
            padding: 12px 12px 9px 13px !important;
        }

       .new-product-details .btn-buy-now {
            background-color: var(--sleepsure-green);
            color: var(--text-light);
            font-weight: bold;
            border: none;
            padding: 10px 0 !important;
        }

       .new-product-details .btn-buy-now:hover {
            background-color: var(--sleepsure-green);
            color: var(--text-light);
        }

        .new-product-details .btn-add-to-cart {
            background-color: var(--sleepsure-blue);
            color: var(--text-light);
            font-weight: bold;
            border: none;
            padding: 10px 0 !important;
        }

       .new-product-details .btn-add-to-cart:hover {
            background-color: var(--sleepsure-blue);
            color: var(--text-light);
        }

        /* ============ Input Fields ============ */
        .new-product-details .custom-field {
            border-radius: 6px;
            padding: 10px;
            border: 1px solid #94b7e5;
            font-size: 16px;
            font-weight: 600;
        }

       .new-product-details .qty-group {
            background: #f1f3f5;
            border-radius: 6px;
            overflow: hidden;
        }

        /* ============ Snap Widget ============ */
       .new-product-details .snap-widget-container {
            width: 100%;
            margin: 15px 0;
            padding: 10px 15px;
            background: #efefef;
            border-radius: 5px;
            cursor: pointer;
            font-family: inherit;
            display: flex;
            align-items: center;
            box-sizing: border-box;
        }

       .new-product-details .snap-main-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .new-product-details .snap-emi-info {
            font-size: 14px;
            color: #000;
            display: flex;
            align-items: center;
        }

       .new-product-details .snap-emi-info .currency,
        .new-product-details .snap-emi-info .amount {
            color: #27803b;
            font-weight: 700;
        }

        .new-product-details .snap-slogan {
            display: flex;
            align-items: center;
            font-size: 12px;
            margin-top: 2px;
        }

       .new-product-details .upi-icon { width: 25px; margin: 0 5px; }
        .new-product-details .snap-brand-logo { width: 80px; margin-left: 5px; }
        .new-product-details .buy-emi-btn { width: 100px; display: block; }

        /* ============ Features Section ============ */
        .new-product-details .product-detail-last-section.mid-section {
            margin-bottom: 40px;
            padding: 40px 0;
        }

        .new-product-details .reviews-slider-pointer-ul {
            display: flex;
            justify-content: space-around;
            text-align: center;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .new-product-details .reviews-slider-pointer-ul li {
            display: flex;
            justify-content: space-around;
            text-align: center;
            position: relative;
            font-family: "Intelo Bold", sans-serif;
            font-size: 14px;
            line-height: 158.8%;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            color: #407DC9;
            padding: 18px 7px;
            flex-grow: 1;
        }

        .new-product-details .reviews-slider-pointer-ul li:after {
            content: '';
            position: absolute;
            left: 0px !important;
            top: 50%;
            transform: translateY(-50%);
            height: 100%;
            width: 1px;
            background: #E5E5E5;
        }

        /* ============ Why Choose Section ============ */
        .new-product-details .whychoose { background-color: #f5f5f5; }

        .new-product-details .whychooseheading {
            padding: 40px 0;
            border-bottom: 1px solid var(--sleepsure-blue);
        }

        .new-product-details .whychoosefeature {
            padding: 80px 0;
            border-bottom: 1px solid var(--sleepsure-blue);
        }

        .new-product-details .whychoosefeature i {
            border: 1px solid var(--sleepsure-blue);
            padding: 4px;
            border-radius: 99px;
        }

        .new-product-details .whychoosefeature .small {
            font-size: 18px;
            color: var(--sleepsure-blue);
        }

        .new-product-details .spec-para { font-size: 18px; }

        /* ============ Policy Tabs ============ */
        .new-product-details .policy-tabs-container {
            display: flex;
            flex-wrap: wrap;
            font-family: sans-serif;
            color: var(--text-dark);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            
        }

        .new-product-details .policy-tabs-container input[type="radio"] { display: none; }

        .new-product-details .policy-tabs-container label {
            padding: var(--spacing-md) var(--spacing-lg);
            cursor: pointer;
            background: #f5f5f5;
            font-weight: bold;
            flex-grow: 1;
            text-align: center;
            transition: all 0.3s ease;
            border-bottom: 2px solid transparent;
        }

       .new-product-details .policy-tabs-container label:hover {
            background: var(--sleepsure-blue);
            color: var(--text-light);
        }

        .new-product-details .policy-tabs-container input:checked + label {
            background: var(--sleepsure-blue);
            color: var(--text-light);
            border-bottom: 2px solid var(--sleepsure-green);
        }

       .new-product-details .tab-content {
            display: none;
            width: 100%;
            padding: var(--spacing-xl);
            background: var(--text-light);
            animation: fadeIn 0.4s ease;
        }

       .new-product-details .tab-content ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .new-product-details .tab-content li {
            padding: var(--spacing-sm) 0;
            border-bottom: 1px solid #eee;
        }

        .new-product-details .tab-content li:last-child { border-bottom: none; }

        /* Show content based on checked radio */
        #tab-delivery:checked ~ .delivery-content,
        #tab-terms:checked ~ .terms-content,
        #tab-return:checked ~ .return-content,
        #tab-warranty:checked ~ .warranty-content,
        #tab-support:checked ~ .support-content { display: block; }

        /* ============ FAQ Section ============ */
       .new-product-details .faq-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 15px;
        }

       .new-product-details .faq-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        /* ============ Animations ============ */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ============ Responsive ============ */
        @media (max-width: 768px) {
           .new-product-details .btn-tab { font-size: 12px; padding: 5px; }
           .new-product-details .pricing h5 { font-size: 1.2rem; }
            
            .new-product-details.snap-widget-container { padding: 8px; }
           .new-product-details .snap-emi-info { font-size: 3.2vw; }
           .new-product-details .snap-slogan { font-size: 2.8vw; }
           .new-product-details .buy-emi-btn { width: 20vw; }
            
            .reviews-slider-pointer-ul li {
                flex: 0 0 50%;
                margin-bottom: 10px;
            }
            
            .whychoosefeature {
                padding: 40px 0;
            }
        }

        @media (max-width: 576px) {
           .new-product-details .main-img-box { height: 300px; }
           .new-product-details .thumb { width: 60px; height: 45px; }
           .new-product-details .product-heading { font-size: 18px; }
            
           ..new-product-details .policy-tabs-container label {
                flex: 0 0 100%;
                border-bottom: 1px solid #ddd;
            }
        }
</style>

    <!-- Breadcrumb Navigation -->
    <section class="new-product-details">
        {{-- <nav class="breadcrumb-nav mb-4">
            <span>HOME > MATTRESS > PRO FITREST LUXURY MATTRESS</span>
        </nav> --}}

        <!-- Main Product Section -->
        <div class="container py-4">
            <div class="row g-5">
                <!-- Product Images -->
                <div class="col-lg-7">

                    <div class="main-img-box">
                        <img src="{{ $product->images[0]->image_url ?? $product->image_url }}" id="mainImg"
                            class="img-fluid rounded" alt="{{ $product->product_name }}">
                        <div class="nav-arrows">
                            <button class="arrow-btn left"><i class="fas fa-chevron-left"></i></button>
                            <button class="arrow-btn right"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <div class="thumb-gallery d-flex gap-2 mt-2">
                        @if (!empty($product->images) && count($product->images) > 0)
                            @foreach ($product->images as $idx => $img)
                                <div class="thumb @if($idx === 0) active @endif" data-index="{{ $idx }}">
                                    <img src="{{ $img->image_url }}" alt="{{ $product->product_name }}" />
                                </div>
                            @endforeach
                        @else
                            <div class="thumb active"><img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" /></div>
                        @endif
                    </div>
                    <p class="text-muted small mt-2">The colour of the actual product may vary from the images shown here.</p>

                    <!-- Gift Banner -->
                    <div class="gift-banner mt-4">
                        <div class="gift-icon-container">
                            <span class="plus-sign">+</span>
                            <img src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/productfreegift/free-gift_3_-1721584073302-1725520482614.webp"
                                alt="gift" width="40">
                        </div>
                        <p class="mb-0 ms-3 fw-bold">1 Cloud pillow with single mattress. 2 Cloud pillows with double size mattress</p>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between">
                        <h1 class="product-heading fw-bold">{{ $product->product_name }}</h1>
                        <div class="share-icons d-flex flex-column gap-1">
                            <i class="fas fa-share-alt text-muted"></i>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="pricing mt-2">
                        <span class="h5 product-price fw-bold">{{ $product->price }}</span>
                        {{-- <span class="text-muted text-decoration-line-through ms-2">{{ $product->previous_price }}</span> --}}
                        <div class="discount-label d-flex justify-content-between small fw-bold mt-1">
                            <p class="text-primary small mt-1">@if((float)$product->original_price > 0)
                                        {{ round(((float)$product->original_price - (float)$product->discount_price) / (float)$product->original_price * 100) }}%
                                    @else
                                        0%
                                    @endif</p>
                            <p class="text-primary small mt-1">* {{ $product->default_variant }}</p>
                        </div>
                        <div class="bottom-text"></div>
                    </div>

                    <!-- Size Tabs -->
                    <div class="size-tabs d-flex gap-2 mt-4">
                        <div class="size-group-options">
                        @foreach ($sizeGroups as $group)
                            <button class="size-group-btn" data-group="{{ $group }}">{{ ucfirst($group) }}</button>
                        @endforeach
                        <button class="size-group-btn" id="customSizeBtn">Custom</button>
                    </div>
                  
                    <!-- Custom size input fields, hidden by default -->
                    <div id="customSizeInputs" style="display:none; margin-top:16px; padding:14px 10px; background:#f8f8f8; border-radius:8px; border:1px solid #e0e0e0; max-width:340px;">
                        <div style="display:flex; gap:16px; align-items:center; justify-content:space-between;">
                            <div style="flex:1;">
                                <label for="customLength" style="font-weight:500; font-size:14px; color:#333;">Length (inches)</label>
                                <input type="number" min="1" id="customLength" name="custom_length" class="custom-size-input" style="width:100%; padding:7px 10px; border:1px solid #ccc; border-radius:5px; margin-top:4px; font-size:15px;" placeholder="e.g. 75" />
                            </div>
                            <div style="flex:1;">
                                <label for="customBreadth" style="font-weight:500; font-size:14px; color:#333;">Breadth (inches)</label>
                                <input type="number" min="1" id="customBreadth" name="custom_breadth" class="custom-size-input" style="width:100%; padding:7px 10px; border:1px solid #ccc; border-radius:5px; margin-top:4px; font-size:15px;" placeholder="e.g. 60" />
                            </div>
                        </div>
                    </div>              
                    </div>

                    <!-- EMI Widget -->
                    <div class="snap-widget-container" id="sm-widget-btn" onclick="startPop()" data-widget="10503">
                        <div class="snap-main-content">
                            <div class="snap-details">
                                <div class="snap-emi-info">
                                    <span class="currency">₹</span>
                                    <b class="amount" id="dp">904</b>
                                    <span class="label">/month,</span>
                                    <span class="tenure"> rest in 3/6/9 months</span>
                                </div>
                                <div class="snap-slogan">
                                    <span class="no-cost-text"><b>0% EMI</b> on</span>
                                    <img src="https://assets.snapmint.com/assets/merchant/UPI_logo_grey__.svg"
                                        class="upi-icon" alt="UPI">
                                    <span class="via-text">via</span>
                                    <img src="https://assets.snapmint.com/assets/merchant/snapmint_logo_black_text.svg"
                                        class="snap-brand-logo" alt="Snapmint">
                                </div>
                            </div>
                            <div class="snap-action-section">
                                <img src="https://assets.snapmint.com/assets/merchant/sleepywell-buyonemi.png"
                                    class="buy-emi-btn" alt="Buy on EMI">
                            </div>
                        </div>
                    </div>

                    <!-- Size & Thickness Selection -->

                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="fw-bold small">Size</label>
                            <a href="#" class="text-primary small text-decoration-none">Size guide <i class="far fa-question-circle"></i></a>
                        </div>
                        <select class="form-select custom-field" id="variantSelect">
                            @foreach($dimensionsByGroup as $group => $dimensions)
                                @foreach($dimensions as $dimensionName => $thicknessArr)
                                    <option value="{{ $thicknessArr[array_key_first($thicknessArr)]['variant_id'] ?? '' }}" @if($thicknessArr[array_key_first($thicknessArr)]['variant_id'] == ($product->default_variant_id ?? '')) selected @endif>{{ $dimensionName }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3">
                        <label class="fw-bold small mb-1">Thickness</label>
                        <select class="form-select custom-field" id="thicknessSelect">
                            @foreach($thicknesses as $thickness)
                                <option value="{{ $thickness->id }}" @if($thickness->id == ($product->default_thickness_id ?? '')) selected @endif>{{ $thickness->thick }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Hidden fields for AJAX price update -->
                    <input type="hidden" id="variant_id" value="{{ $product->default_variant_id ?? '' }}">
                    <input type="hidden" id="thickness_id" value="{{ $product->default_thickness_id ?? '' }}">
                    <input type="hidden" id="hiddenProductPrice" value="{{ $product->price }}">
                    <input type="hidden" id="hiddenCustomLength" name="custom_length" value="">
                    <input type="hidden" id="hiddenCustomBreadth" name="custom_breadth" value="">

                    <!-- Selection Summary -->
                    <div class="selection-details mt-3 p-2">
                        <div class="text-muted small">Final size selected</div>
                        <div class="fw-bold text-primary small" id="selectedSizeDisplay">
                            {{ $product->default_variant_name ?? '' }} x {{ $product->default_thickness_name ?? '' }}
                        </div>
                    </div>

                    <!-- Quantity & Delivery -->
                    <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-5">
                                <label class="small fw-bold mb-1">Quantity</label>
                                <div class="input-group qty-group">
                                    <button type="button" id="qtyMinus" class="btn product-btn border">-</button>
                                    <input type="number" id="quantityInput" class="form-control text-center border-0" name="quantity" value="1" min="1" style="background-color: #f1f3f5;" readonly>
                                    <button type="button" id="qtyPlus" class="btn product-btn border">+</button>
                                </div>
                            </div>
                            <div class="col-7">
                                <label class="small fw-bold mb-1">Check for the delivery details</label>
                                <input type="text" class="form-control custom-field" name="pincode" placeholder="Enter pincode">
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="variant_id" id="formVariantId" value="{{ $product->default_variant_id ?? ($variants[0]->variant_id ?? '') }}">
                        <input type="hidden" name="thickness_id" id="formThicknessId" value="{{ $product->default_thickness_id ?? ($thicknesses[0]->id ?? '') }}">
                        <input type="hidden" name="price" id="formProductPrice" value="{{ $product->price }}">
                        <div class="row mt-4 g-2">
                            <div class="col-6">
                                <button type="submit" class="btn btn-add-to-cart w-100 py-3">ADD TO CART</button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-buy-now w-100 py-3" id="buyNowBtn">BUY NOW</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section class="product-detail-last-section customisation-section mid-section">
            <div class="container">
                <ul class="reviews-slider-pointer-ul">
                    <li style="color:#8C4799"><a href="/store"><img loading="lazy" alt="BRAND OUTLETS" decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/groupone%20(1)-1672931221569.svg">
                            BRAND OUTLETS</a></li>
                    <li style="color:#FF8230"><a href="/no-cost-emi"><img loading="lazy" alt="NO COST EMI"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/No%20cost%20Emi_S%20(1)%202-1673871768155-1691068740147.svg">
                            NO COST EMI</a></li>
                    <li style="color:#588DD0"><a href="/newTermsandcondition"><img loading="lazy" alt="FREE DELIVERY"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/Free%20Delivery%20&amp;%20Returns_-1632806416567-1691134584370.svg">
                            FREE DELIVERY</a></li>
                    <li style="color:#385572"><a href="/newTermsandcondition"><img loading="lazy" alt="CUSTOM SIZE"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/Coustom%20Size%20(7)-1691395248062.svg">
                            CUSTOM SIZE</a></li>
                    <li style="color:#FFA500"><a href="/mattresses/all-mattress"><img loading="lazy" alt="WIDE RANGE"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/wide-1632115174468.svg">
                            WIDE RANGE</a></li>
                    <li style="color:#FF6F0F"><a href="/newWarrancy-policy"><img loading="lazy" alt="25 YEARS WARRANTY*"
                                decoding="async"
                                src="https://mysleepwell.s3.ap-south-1.amazonaws.com/uploads/benifits/warranty-1629908552318%20(1)-1696917148396.svg">
                            25 YEARS WARRANTY*</a></li>
                </ul>
            </div>
        </section>

        <!-- Why Choose Section -->
        <section class="whychoose">
            <div class="container mt-5 py-4 border-top">
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="whychooseheading">
                            <h3 class="fw-bold mb-4">Why Choose Bond Tuff?</h3>
                        </div>
                        <div class="whychoosefeature row g-4">
                            <div class="col-md-3">
                                <h2>Features</h2>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-4">
                                    <div class="col-md-4 col-6 d-flex align-items-start">
                                        <i class="fas fa-layer-group text-primary me-3 mt-1"></i>
                                        <p class="small mb-0">High Density Premium Bonded Foam Core</p>
                                    </div>
                                    <div class="col-md-4 col-6 d-flex align-items-start">
                                        <i class="fas fa-bone text-primary me-3 mt-1"></i>
                                        <p class="small mb-0">Superior Spine Alignment Support</p>
                                    </div>
                                    <div class="col-md-4 col-6 d-flex align-items-start">
                                        <i class="fas fa-wind text-primary me-3 mt-1"></i>
                                        <p class="small mb-0">Breathable Premium Knitted Fabric</p>
                                    </div>
                                    <div class="col-md-4 col-6 d-flex align-items-start">
                                        <i class="fas fa-thumbs-up text-primary me-3 mt-1"></i>
                                        <p class="small mb-0">Medium-Firm Support Feel</p>
                                    </div>
                                    <div class="col-md-4 col-6 d-flex align-items-start">
                                        <i class="fas fa-certificate text-primary me-3 mt-1"></i>
                                        <p class="small mb-0">HD Foam Quilting Layer</p>
                                    </div>
                                    <div class="col-md-4 col-6 d-flex align-items-start">
                                        <i class="fas fa-shield-alt text-primary me-3 mt-1"></i>
                                        <p class="small mb-0">Durable Construction</p>
                                    </div>
                                    <div class="col-md-4 col-6 d-flex align-items-start">
                                        <i class="fas fa-calendar-check text-primary me-3 mt-1"></i>
                                        <p class="small mb-0">60-month warranty</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="row align-items-center">
                    <h3 class="fw-bold mb-4">Mattress Specifications</h3>
                    <div class="col-md-7">
                        <div class="position-relative">
                            <img src="assets/img2/P4 (1).jpg" class="img-fluid" alt="Bond Tuff Layers"
                                style="aspect-ratio: 3/2;object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="spec-list ps-md-4">
                            <div class="spec-item mb-4 d-flex">
                                <span class="step-num me-3">1</span>
                                <div>
                                    <h5 class="fw-bold mb-1">Premium Knitted Fabric</h5>
                                    <p class="text-muted spec-para mb-0">Soft, breathable, and skin-friendly for
                                        enhanced sleep comfort.</p>
                                </div>
                            </div>
                            <div class="spec-item mb-4 d-flex">
                                <span class="step-num me-3">2</span>
                                <div>
                                    <h5 class="fw-bold mb-1">HD Foam Quilting</h5>
                                    <p class="text-muted spec-para mb-0">Adds cushioning and improves pressure
                                        distribution.</p>
                                </div>
                            </div>
                            <div class="spec-item mb-4 d-flex">
                                <span class="step-num me-3">3</span>
                                <div>
                                    <h5 class="fw-bold mb-1">High Density PU Foam</h5>
                                    <p class="text-muted spec-para mb-0">Improves comfort and support transition.</p>
                                </div>
                            </div>
                            <div class="spec-item mb-4 d-flex">
                                <span class="step-num me-3">4</span>
                                <div>
                                    <h5 class="fw-bold mb-1">High Density Rebonded Foam</h5>
                                    <p class="text-muted spec-para mb-0">Strong base layer that ensures firmness,
                                        durability, and spinal support.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Policy Tabs -->
        <div class="policy-tabs-container">
            <input type="radio" name="policy-tabs" id="tab-delivery" checked>
            <label for="tab-delivery">Delivery Policy</label>

            <input type="radio" name="policy-tabs" id="tab-terms">
            <label for="tab-terms">Terms & Conditions</label>

            <input type="radio" name="policy-tabs" id="tab-return">
            <label for="tab-return">Return Policy</label>

            <input type="radio" name="policy-tabs" id="tab-warranty">
            <label for="tab-warranty">Warranty Claims</label>

            <input type="radio" name="policy-tabs" id="tab-support">
            <label for="tab-support">Customer Support</label>

            <div class="tab-content delivery-content">
                <ul>
                    <li><strong>Free shipping</strong> across India</li>
                    <li>Delivery within <strong>3–7 business days</strong></li>
                    <li>Real-time order tracking provided after dispatch</li>
                </ul>
            </div>
            <div class="tab-content terms-content">
                <ul>
                    <li>Lorem ipsum dolor sit amet consectetur.</li>
                    <li>Lorem ipsum dolor sit, amet consectetur adipisicing.</li>
                    <li>Lorem ipsum dolor sit amet consectetur adipisicing.</li>
                </ul>
            </div>

            <div class="tab-content return-content">
                <ul>
                    <li><strong>100-night risk-free trial</strong> - Try the mattress in the comfort of your home</li>
                    <li>Full refund if not satisfied</li>
                    <li>Simple, no questions asked return policy</li>
                </ul>
            </div>

            <div class="tab-content warranty-content">
                <ul>
                    <li><strong>10-year manufacturer warranty</strong> against manufacturing defects</li>
                    <li>Covers issues related to foam sagging and material defects</li>
                    <li>Easy online warranty claim process</li>
                    <li>Dedicated support team with <strong>48-hour response time</strong></li>
                </ul>
            </div>

            <div class="tab-content support-content">
                <ul>
                    <li><strong>24/7 customer support</strong> via phone, email, and live chat</li>
                    <li>Access to dedicated <strong>sleep experts</strong> for guidance</li>
                    <li>Quick resolution support for delivery, returns, and warranty claims</li>
                </ul>
            </div>
        </div>

        <!-- FAQ Section -->
        <section class="faq-section">
            <h1 class="faq-title">Frequently Asked Questions</h1>

            <div class="accordion" id="faqAccordion">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Is the Bond Tuff mattress good for back pain?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. Bond Tuff is made using high density bonded foam that provides firm support and helps
                            maintain proper spinal alignment. This reduces pressure on the lower back and joints, making
                            it
                            suitable for people experiencing back pain or body aches.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            What type of firmness does the Bond Tuff mattress offer?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            The Bond Tuff mattress offers medium-firm to firm support. It is ideal for sleepers who
                            prefer a
                            stable surface that does not sink and provides consistent body support throughout the night.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Is this mattress suitable for spinal cord or posture-related issues?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. The firm rebonded foam core helps keep the spine in a neutral position while sleeping,
                            which is beneficial for posture correction and spinal support.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            What materials are used in the Bond Tuff mattress?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Bond Tuff is constructed using premium knitted fabric, HD foam quilting, high density PU
                            foam,
                            and a high density rebonded foam base for durability and firmness.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Does the mattress feel hard?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            No. While the support is firm, the HD foam quilting and premium knitted fabric add surface
                            comfort, so the mattress does not feel hard or uncomfortable.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            Is this mattress good for heavier individuals?
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. The firm bonded foam structure provides strong support and evenly distributes body
                            weight,
                            making it suitable for heavier sleepers.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            Does the Bond Tuff mattress come with a warranty?
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. The mattress comes with a 60-month manufacturer warranty covering manufacturing
                            defects.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNine">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            Is Bond Tuff a good budget mattress?
                        </button>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. Bond Tuff offers premium materials, firm support, and long-term durability at a
                            value-driven price, making it one of the best options in the budget firm mattress category.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            Is the mattress breathable?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. The fabric allows better air circulation, helping reduce heat buildup and improving
                            sleep
                            comfort.
                        </div>
                    </div>
                </div>


                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            What thickness should I choose?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            • 4 inches is suitable for guest rooms or occasional use
                            • 5 inches is ideal for daily use with balanced support
                            • 6 inches offers enhanced comfort while retaining firmness

                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            Can this mattress be used on any type of bed?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Yes. It works well on wooden cots, metal frames, and flat surfaces. It is suitable for most
                            standard Indian bed frames.

                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            Is this mattress suitable for all sleeping positions?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            It is best suited for back sleepers and stomach sleepers who need firm support. Side
                            sleepers who prefer firm mattresses may also find it comfortable.

                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            Does the mattress sag over time?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            No. The high density rebonded foam is designed to resist sagging and maintain shape even
                            with long-term daily use.

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
        // Image Gallery Functionality
        function updateImg(element) {
            const mainImg = document.getElementById('mainImg');
            mainImg.src = element.src;

            // Update active class
            document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
            element.parentElement.classList.add('active');
        }

        // Slider Navigation
        const leftBtn = document.querySelector('.arrow-btn.left');
        const rightBtn = document.querySelector('.arrow-btn.right');

        function changeImage(direction) {
            const thumbnails = document.querySelectorAll('.thumb img');
            const currentImgSrc = document.getElementById('mainImg').getAttribute('src');

            let currentIndex = Array.from(thumbnails).findIndex(img => img.getAttribute('src') === currentImgSrc);

            if (direction === 'next') {
                currentIndex = (currentIndex + 1) % thumbnails.length;
            } else {
                currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            }

            updateImg(thumbnails[currentIndex]);
        }

        // Event Listeners
        rightBtn.addEventListener('click', () => changeImage('next'));
        leftBtn.addEventListener('click', () => changeImage('prev'));
    </script>

    <script>
                        // Debounce utility (define at top level)
                        function debounce(func, wait) {
                            let timeout;
                            return function(...args) {
                                clearTimeout(timeout);
                                timeout = setTimeout(() => func.apply(this, args), wait);
                            };
                        }

                        // Sync hidden form fields with selection
                        function syncFormFields() {
                            const variantSelect = document.getElementById('variantSelect');
                            const thicknessSelect = document.getElementById('thicknessSelect');
                            const formVariantId = document.getElementById('formVariantId');
                            const formThicknessId = document.getElementById('formThicknessId');
                            if (formVariantId && variantSelect) {
                                formVariantId.value = variantSelect.value;
                            }
                            if (formThicknessId && thicknessSelect) {
                                formThicknessId.value = thicknessSelect.value;
                            }
                        }

                        document.addEventListener('DOMContentLoaded', function() {
                            const variantSelect = document.getElementById('variantSelect');
                            const thicknessSelect = document.getElementById('thicknessSelect');
                            const formVariantId = document.getElementById('formVariantId');
                            const formThicknessId = document.getElementById('formThicknessId');
                            const formProductPrice = document.getElementById('formProductPrice');
                            const hiddenProductPrice = document.getElementById('hiddenProductPrice');
                            // Set default values if not selected
                            syncFormFields();
                            if (variantSelect && formVariantId) {
                                variantSelect.addEventListener('change', function() {
                                    syncFormFields();
                                });
                            }
                            if (thicknessSelect && formThicknessId) {
                                thicknessSelect.addEventListener('change', function() {
                                    syncFormFields();
                                });
                            }
                            if (hiddenProductPrice && formProductPrice) {
                                // Update price field whenever price changes
                                const observer = new MutationObserver(function() {
                                    formProductPrice.value = hiddenProductPrice.value;
                                });
                                observer.observe(hiddenProductPrice, { attributes: true, childList: true, subtree: true });
                            }
                            // Ensure form fields are synced before form submit
                            const addToCartForm = document.getElementById('addToCartForm');
                            if (addToCartForm) {
                                addToCartForm.addEventListener('submit', function(e) {
                                    syncFormFields();
                                });
                            }
                        });
                        // Buy Now button submits form
                        document.addEventListener('DOMContentLoaded', function() {
                            const buyNowBtn = document.getElementById('buyNowBtn');
                            const addToCartForm = document.getElementById('addToCartForm');
                            if (buyNowBtn && addToCartForm) {
                                buyNowBtn.addEventListener('click', function() {
                                    addToCartForm.submit();
                                });
                            }
                        });
                // Quantity increment/decrement logic
                document.addEventListener('DOMContentLoaded', function() {
                    const qtyInput = document.getElementById('quantityInput');
                    const qtyMinus = document.getElementById('qtyMinus');
                    const qtyPlus = document.getElementById('qtyPlus');
                    if (qtyInput && qtyMinus && qtyPlus) {
                        qtyMinus.addEventListener('click', function() {
                            let val = parseInt(qtyInput.value, 10) || 1;
                            if (val > 1) {
                                qtyInput.value = val - 1;
                            }
                        });
                        qtyPlus.addEventListener('click', function() {
                            let val = parseInt(qtyInput.value, 10) || 1;
                            qtyInput.value = val + 1;
                        });
                    }
                });
        // Image Gallery Functionality (Dynamic)
        document.addEventListener('DOMContentLoaded', function() {
            const mainImg = document.getElementById('mainImg');
            const thumbs = document.querySelectorAll('.thumb-gallery .thumb');
            const leftBtn = document.querySelector('.arrow-btn.left');
            const rightBtn = document.querySelector('.arrow-btn.right');

            let currentIndex = 0;
            const images = Array.from(thumbs).map(t => t.querySelector('img').getAttribute('src'));

            function updateImgByIndex(idx) {
                if (images.length === 0) return;
                currentIndex = idx;
                mainImg.src = images[idx];
                thumbs.forEach(t => t.classList.remove('active'));
                if (thumbs[idx]) thumbs[idx].classList.add('active');
            }

            thumbs.forEach((thumb, idx) => {
                thumb.addEventListener('click', function() {
                    updateImgByIndex(idx);
                });
            });

            function changeImage(direction) {
                if (direction === 'next') {
                    currentIndex = (currentIndex + 1) % images.length;
                } else {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                }
                updateImgByIndex(currentIndex);
            }

            if (rightBtn) rightBtn.addEventListener('click', () => changeImage('next'));
            if (leftBtn) leftBtn.addEventListener('click', () => changeImage('prev'));

            // Set initial image
            updateImgByIndex(0);
        });

        // Dynamic Size & Thickness Price Update
        function updateProductPrice(variantId, thicknessId, productId) {
            // Get custom size values if present
            const customLength = document.getElementById('hiddenCustomLength')?.value || '';
            const customBreadth = document.getElementById('hiddenCustomBreadth')?.value || '';
            fetch("{{ route('product.variantPrice') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    variant_id: variantId,
                    thickness_id: thicknessId,
                    product_id: productId,
                    custom_length: customLength,
                    custom_breadth: customBreadth
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.product-price').textContent = data.price;
                    document.getElementById('hiddenProductPrice').value = data.price;
                    var formPrice = document.getElementById('formProductPrice');
                    if (formPrice) formPrice.value = data.price;
                } else {
                    document.querySelector('.product-price').textContent = 'N/A';
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error fetching price');
            });
        }

        // Debounced version (define at top level)
        const debouncedUpdateProductPrice = debounce(updateProductPrice, 350);

        document.addEventListener('DOMContentLoaded', function() {
            const variantSelect = document.getElementById('variantSelect');
            const thicknessSelect = document.getElementById('thicknessSelect');
            const productId = '{{ $product->product_id }}';
            const selectedSizeDisplay = document.getElementById('selectedSizeDisplay');

            function updateSelectionDisplay() {
                // If custom size is selected, show custom length and breadth
                const customLength = document.getElementById('hiddenCustomLength')?.value;
                const customBreadth = document.getElementById('hiddenCustomBreadth')?.value;
                const customBtn = document.getElementById('customSizeBtn');
                if (customBtn && customBtn.classList.contains('active') && customLength && customBreadth) {
                    selectedSizeDisplay.textContent = `Custom: ${customLength} x ${customBreadth}`;
                } else {
                    const variantText = variantSelect.options[variantSelect.selectedIndex].text;
                    const thicknessText = thicknessSelect.options[thicknessSelect.selectedIndex].text;
                    selectedSizeDisplay.textContent = variantText + ' x ' + thicknessText;
                }
            }

            variantSelect.addEventListener('change', function() {
                document.getElementById('variant_id').value = this.value;
                updateProductPrice(this.value, thicknessSelect.value, productId);
                updateSelectionDisplay();
            });
            thicknessSelect.addEventListener('change', function() {
                document.getElementById('thickness_id').value = this.value;
                updateProductPrice(variantSelect.value, this.value, productId);
                updateSelectionDisplay();
            });

            // Set initial display
            updateSelectionDisplay();
        });

        // Custom size price update logic
        function triggerCustomPriceUpdate() {
            const customBtn = document.getElementById('customSizeBtn');
            const customLength = document.getElementById('customLength')?.value;
            const customBreadth = document.getElementById('customBreadth')?.value;
            const productId = '{{ $product->product_id }}';
            if (customBtn && customBtn.classList.contains('active') && customLength && customBreadth) {
                document.getElementById('hiddenCustomLength').value = customLength;
                document.getElementById('hiddenCustomBreadth').value = customBreadth;
                // Call price update with custom values
                updateProductPrice('', '', productId);
                // Update selection summary
                document.getElementById('selectedSizeDisplay').textContent = `Custom: ${customLength} x ${customBreadth}`;
            }
        }
        ['input', 'change'].forEach(evt => {
            document.getElementById('customLength')?.addEventListener(evt, triggerCustomPriceUpdate);
            document.getElementById('customBreadth')?.addEventListener(evt, triggerCustomPriceUpdate);
        });
        document.addEventListener('DOMContentLoaded', function() {
                    const customBtn = document.getElementById('customSizeBtn');
                    const customInputs = document.getElementById('customSizeInputs');
                    const sizeBtns = document.querySelectorAll('.size-group-btn');
                    const variantSelect = document.getElementById('variantSelect');
                    const thicknessSelect = document.getElementById('thicknessSelect');
                    const selectedSizeDisplay = document.getElementById('selectedSizeDisplay');
                    // Hide variant/thickness selects when custom is active
                    function updateSizeTabDisplay() {
                        if (customBtn.classList.contains('active')) {
                            if (variantSelect) variantSelect.style.display = 'none';
                            if (thicknessSelect) thicknessSelect.style.display = '';
                            if (customInputs) customInputs.style.display = 'block';
                        } else {
                            if (variantSelect) variantSelect.style.display = '';
                            if (thicknessSelect) thicknessSelect.style.display = '';
                            if (customInputs) customInputs.style.display = 'none';
                        }
                    }
                    sizeBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            sizeBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            updateSizeTabDisplay();
                            syncFormFields();
                            if (this === customBtn) {
                                const customLength = document.getElementById('customLength').value;
                                const customBreadth = document.getElementById('customBreadth').value;
                                document.getElementById('hiddenCustomLength').value = customLength;
                                document.getElementById('hiddenCustomBreadth').value = customBreadth;
                                if (selectedSizeDisplay) {
                                    selectedSizeDisplay.textContent = customLength && customBreadth ? `Custom: ${customLength} x ${customBreadth}` : 'Custom Size';
                                }
                                // Always require thickness for custom
                                const thicknessId = thicknessSelect?.value || '';
                                const productId = '{{ $product->product_id }}';
                                debouncedUpdateProductPrice('', thicknessId, productId);
                            } else {
                                if (selectedSizeDisplay) selectedSizeDisplay.textContent = this.textContent;
                                const productId = '{{ $product->product_id }}';
                                debouncedUpdateProductPrice(variantSelect.value, thicknessSelect.value, productId);
                            }
                        });
                    });
                    // Initial display
                    updateSizeTabDisplay();
                    function triggerCustomPriceUpdate() {
                        if (!customBtn.classList.contains('active')) return;
                        const customLength = document.getElementById('customLength').value;
                        const customBreadth = document.getElementById('customBreadth').value;
                        document.getElementById('hiddenCustomLength').value = customLength;
                        document.getElementById('hiddenCustomBreadth').value = customBreadth;
                        if (selectedSizeDisplay) {
                            selectedSizeDisplay.textContent = customLength && customBreadth ? `Custom: ${customLength} x ${customBreadth}` : 'Custom Size';
                        }
                        // Always require thickness for custom
                        const thicknessId = thicknessSelect?.value || '';
                        const productId = '{{ $product->product_id }}';
                        updateProductPrice('', thicknessId, productId);
                    }
                    ['input', 'change'].forEach(evt => {
                        document.getElementById('customLength')?.addEventListener(evt, triggerCustomPriceUpdate);
                        document.getElementById('customBreadth')?.addEventListener(evt, triggerCustomPriceUpdate);
                    });
                });


                 const dimensionsByGroup = @json($dimensionsByGroup);
                document.addEventListener('DOMContentLoaded', function() {
                    const sizeBtns = document.querySelectorAll('.size-group-btn');
                    const variantSelect = document.getElementById('variantSelect');
                    const thicknessSelect = document.getElementById('thicknessSelect');
                    const priceDisplay = document.querySelector('.product-price');
                    const productId = '{{ $product->product_id }}';
                    sizeBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            sizeBtns.forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            const group = this.dataset.group;
                            if (this.id === 'customSizeBtn') {
                                priceDisplay.textContent = document.getElementById('hiddenProductPrice').value;
                                updateProductPrice('', thicknessSelect.value, productId);
                                return;
                            }
                            if (!group || !dimensionsByGroup[group]) return;
                            variantSelect.innerHTML = '';
                            Object.entries(dimensionsByGroup[group]).forEach(([dimensionName, thicknessArr]) => {
                                const variantId = thicknessArr[Object.keys(thicknessArr)[0]].variant_id;
                                const option = document.createElement('option');
                                option.value = variantId;
                                option.textContent = dimensionName;
                                variantSelect.appendChild(option);
                            });
                            thicknessSelect.innerHTML = '';
                            const firstDimension = Object.values(dimensionsByGroup[group])[0];
                            if (firstDimension) {
                                Object.values(firstDimension).forEach(thicknessObj => {
                                    const option = document.createElement('option');
                                    option.value = thicknessObj.id;
                                    option.textContent = thicknessObj.thick;
                                    thicknessSelect.appendChild(option);
                                });
                            }                            
                            debouncedUpdateProductPrice(variantSelect.value, thicknessSelect.value, productId);
                        });
                    });
                    variantSelect.addEventListener('change', function() {
                        syncFormFields();
                        debouncedUpdateProductPrice(this.value, thicknessSelect.value, productId);
                    });
                    thicknessSelect.addEventListener('change', function() {
                        syncFormFields();
                        debouncedUpdateProductPrice(variantSelect.value, this.value, productId);
                    });
                });
    </script>

@endsection