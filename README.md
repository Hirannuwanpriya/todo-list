# 📝 Todo List (Vue + Laravel + MySQL + Docker)

A full-stack Todo List application built with:

- 🧩 **Vue 3** (Frontend)
- 🧱 **Laravel 10** (Backend API)
- 🗄️ **MySQL** (Database)
- 🐳 **Docker Compose** for seamless development setup

---

## 📦 Project Structure

```
todo-list/
├── backend/            # Laravel API
├── frontend/           # Vue 3 App
├── docker-compose.yml  # Docker setup
└── README.md
```

---

## 🚀 Quick Start with Docker

### 1. Clone the Repository

```bash
git clone https://github.com/Hirannuwanpriya/todo-list.git
cd todo-list
```

### 2. Copy Environment Files

```bash
cp backend/.env.example backend/.env
```

Update the `.env` with:

```
DB_HOST=db
DB_PORT=3306
DB_DATABASE=todo
DB_USERNAME=root
DB_PASSWORD=root
```

### 3. Build and Run Containers

```bash
docker-compose up --build
```

This will start:

- **Vue Frontend** on [http://localhost:3000](http://localhost:3000)
- **Laravel API** on [http://localhost:8000](http://localhost:8000)
- **MySQL DB** on port `3306`

### 4. Run Laravel Setup Commands

Once the containers are up, run:

```bash
docker exec -it backend-app bash
composer install
php artisan key:generate
php artisan migrate
```

---

## 🧪 API Endpoints (Laravel)

| Method | Endpoint         | Description           |
|--------|------------------|-----------------------|
| GET    | /api/tasks       | List all tasks        |
| POST   | /api/tasks       | Add a new task        |
| PUT    | /api/tasks/{id}  | Mark task as done     |
| DELETE | /api/tasks/{id}  | Delete a task         |

---

## 🛠️ Development

### Frontend (Vue 3)

```bash
cd frontend
npm install
npm run dev
```

### Backend (Laravel)

```bash
cd backend
composer install
php artisan serve
```

---

## 🧹 Useful Commands

### Stop Containers

```bash
docker-compose down
```

### Rebuild Without Cache

```bash
docker-compose build --no-cache
```

---

## 📚 License

MIT License © 2025 [Hiran Nuwanpriya](https://github.com/Hirannuwanpriya)
