# BuildTrack

**BuildTrack** is a website project management tool that uses **boards**, **lists**, and **cards** to help teams organize tasks, track progress, and collaborate efficiently — similar to Trello.

---

## 🚀 Features

### 1. Boards
- Represent a project or workspace.
- Contain lists and cards.

### 2. Lists
- Represent stages or categories (e.g., *To Do*, *In Progress*, *Done*).
- Used to organize tasks within a board.

### 3. Cards
- Represent individual tasks or items.
- Can include:
  - Descriptions
  - Comments
  - Due dates
  - Attachments
  - Labels
- Can be moved between lists to track progress.

### 4. Labels
- Color-coded tags to categorize or prioritize cards.

### 5. Due Dates
- Assign deadlines to cards.
- Notifications remind users before a task is due.

### 6. Checklists
- Break down tasks into smaller subtasks.

### 7. Members
- Assign users to cards to indicate responsibility.

### 8. Comments
- Communicate with team members directly on cards.

---

## 🛠️ Requirements

- PHP 7.4 or higher  
- MySQL 5.7 or higher  
- Composer  
- XAMPP (or similar local development environment)

---

## 📦 Installation

### 1.Clone the repository by running the following command in your terminal:
### 2.git clone https://github.com/yourusername/Construcstore.git
### 3.Then navigate into the project directory:
### 4.Create a .env file in the root directory with the following variables: DB_HOST=localhost DB_NAME=construct  DB_USER=your_database_users DB_USER=your_database_task DB_USER=your_database_clients  EMAIL_PASS=your_gmail_app_password GOOGLE_CLIENT_ID=your_google_client_secret GOOGLE_CLIENT_SECRET=https://localhost/ConstrucStore/google-callback.php

### 5.import the database schema: mysql -u your_database_user -p your_database_name < import.sql

### 6.Configure Google OAuth:

- Go to the [Google Cloud Console](https://console.cloud.google.com/)
- Create a new project or select an existing one
- Enable the Google+ API
- Create OAuth 2.0 credentials
- Add the redirect URL: `http://localhost/hj-gownshop/googleAuth/google-callback.php`

## Usage
### 1. Start your local server (XAMPP, etc.)
### 2. Navigate to http://localhost/ConstructStore/
### 3. Register a new account or log in with Google


## Project Structure

- 📁 **assets/** – Images, CSS, and JavaScript files  
- 👤 **admin/** – User dashboard files  
- 🛠️ **administrator/** – Admin dashboard files  
- 🧩 **includes/** – Database connection and utility scripts  
- 🔐 **google-auth/** – Google OAuth integration  
- 🎨 **styles/** – CSS stylesheets  
- 📦 **vendor/** – Composer dependencies  



## Contact
-for more questions please contant me on email:reys10801@gmail.com
