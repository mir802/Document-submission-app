# 📄 Document Submission App

A Laravel-based web application designed for **universities and educational institutions** to facilitate the submission, review, and management of **research documents**.

---

## 🎯 Purpose

The Document Submission App streamlines the process of:

- Submitting research proposals, theses, dissertations, or project documents
- Allowing reviewers or supervisors to track, comment, and approve documents
- Enabling researchers to view the status of their submissions in real-time

---

## 🏛️ Who It's For

- University research offices
- Graduate program coordinators
- Academic advisors and supervisors
- Researchers and postgraduate students

---

## ✨ Key Features

- 🔐 User Authentication (Students, Supervisors, Admin)
- 📤 Secure Document Upload and Storage
- 📝 Document Review & Status Tracking
- 📨 Email Notifications and Alerts
- 📊 Dashboard for Admin and Reviewers
- 🔍 Search & Filter Submissions

---

## 🛠️ Built With

- Laravel (PHP Framework)
- Blade Templating Engine
- MySQL / PostgreSQL
- Bootstrap / Tailwind CSS (based on UI version)
- Optional: Laravel Breeze / Jetstream for authentication scaffolding

---

## 🚀 Getting Started

To set up the app locally:

```bash
git clone git@github.com:mir802/Document-submission-app.git
cd Document-submission-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
