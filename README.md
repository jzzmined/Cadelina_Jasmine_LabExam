# Glow – Login and Registration System

## About
Glow is a beauty and confidence brand concept. This project is a Login and Registration System built for a UI/UX and PHP laboratory exam. The interface was designed in Figma, with a maroon arch card, a warm tan background and a blurred portrait, and then implemented with PHP, HTML, CSS and JavaScript.

**Figma Design:** https://www.figma.com/design/E5WBO5LosUBOWrmaCEgymo/CS15--LabAct-3?node-id=0-1&t=BlLwv0TKTg6vEk8E-1.

**Screen Recording:** [Watch the demo](screen%20recording/labexam2-screenrec.mp4) (GitHub may ask you to view raw or download the file)

## Features
- Landing page, Login page, Sign Up page and a protected Dashboard
- Navigation between Login and Sign Up
- Validation with error messages:
  - Required fields
  - Valid email format
  - Strong password (8+ characters, uppercase, lowercase and a number)
  - Password confirmation
  - Valid PH phone number (e.g. 09123456789)
  - Duplicate email check
- Success messages after registering and logging in
- Show/hide password toggle and "Remember me"
- Passwords stored securely with `password_hash()`, CSRF protection and escaped output

## Project Structure
```
├── index.php, login.php, register.php, dashboard.php, logout.php
├── includes/        shared functions and page head
├── assets/          css, js and images
├── data/users.json  registered users
└── screen recording/
```

## How to Run
1. Install XAMPP and start **Apache**.
2. Copy this folder into `C:\xampp\htdocs\`.
3. Open `http://localhost/<folder-name>/login.php` in your browser.

## Tools Used
PHP, HTML, CSS, JavaScript, Figma, XAMPP, GitHub

**Author:** Jasmine Cadelina
