# 🛡️ SafeHer Bangladesh
**AI-Driven Women Safety & Empowerment Platform**

**SafeHer Bangladesh** is a comprehensive web-based platform designed to ensure the online and offline safety of women in Bangladesh. The project features a real-time Emergency SOS system, AI-based safe route suggestions, and a secure community forum for empowerment.

---

## 🚀 Key Features
1.  **SOS Alert System:** Sends instant emergency alerts with live GPS location to admins and trusted contacts.
2.  **Safe Route Suggestion:** Suggests the safest paths based on crowd-sourced crime data and incident history.
3.  **Women-Only Forum:** A safe, moderated space for women to share experiences and seek advice.
4.  **AI Mental Health Chatbot:** A 24/7 AI assistant providing mental health support and safety tips.
5.  **Admin Dashboard:** A centralized panel for monitoring SOS alerts, managing users, and analyzing safety data.

---

## 👥 Team Members & Task Distribution

### 👨‍💻 1. Md. Sajid Rahman (Team Leader)
* **Role:** Full Stack Developer & System Architect.
* **Responsibilities:**
    * Project Repository Setup & Management.
    * **Authentication System:** Login/Registration with Role Management (User vs. Admin).
    * **SOS Alert System:** Built the database structure, backend controller logic, and API for location tracking.
    * **Admin Panel:** implemented `AdminMiddleware` for security and developed the main Admin Dashboard.
    * Code merging and final integration.

### 👨‍💻 2. Zahin Muntaha Khan
* **Role:** Full Stack Developer.
* **Assigned Feature:** **Safe Route Suggestion System**.
* **Tasks:**
    * Designed `safe_routes` database schema and migrations.
    * Developed `SafeRouteController` for CRUD operations.
    * Created the Admin interface for adding/editing safe routes.
    * Integrated Map visualization (Google Maps/Leaflet) for routes.
    * Implemented the **Crime Score Logic** (Safety rating system).

### 👨‍💻 3. Member 3 (Name)
* **Role:** Frontend & Backend Developer.
* **Assigned Feature:** **Women-Only Community Forum**.
* **Tasks:**
    * Developed the Post creation, editing, and deletion system.
    * Implemented the commenting system.
    * Basic content filtering logic for harassment detection.

### 👨‍💻 4. Member 4 (Name)
* **Role:** AI/API Integration Specialist.
* **Assigned Feature:** **AI Chatbot & Mental Health Support**.
* **Tasks:**
    * Integrated AI API (OpenAI/Dummy Logic) for the Chatbot.
    * Designed the Chat interface for mental health support.

---

## 🛠️ Tech Stack
* **Backend:** Laravel 10 (PHP)
* **Frontend:** Blade Templates, Tailwind CSS, JavaScript
* **Database:** MySQL
* **Tools:** Git, GitHub, VS Code, XAMPP/MySQL Workbench

---

## ⚙️ Installation Guide (Local Setup)

If you want to run this project on your local machine, follow these steps:

**1. Clone the Repository:**
```bash
git clone [https://github.com/your-username/safeherbd-new.git](https://github.com/your-username/safeherbd-new.git)
cd safeherbd-new
