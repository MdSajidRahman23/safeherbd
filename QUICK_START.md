# 🚀 SafeHer Bangladesh - Quick Start Guide

## Current Status
✅ **Project COMPLETE and RUNNING**
- Laravel Server: http://127.0.0.1:8000
- Vite Dev Server: http://localhost:5173
- Database: Connected & Migrated
- All Features: Functional

---

## 🎯 Access Points

### 1. **Landing Page** (Public)
```
http://127.0.0.1:8000
```
- Hero section with feature overview
- Login/Register links
- Navigation

### 2. **Authentication** (Public)
```
Login:    http://127.0.0.1:8000/login
Register: http://127.0.0.1:8000/register
```

### 3. **User Dashboard** (Requires Login)
```
http://127.0.0.1:8000/dashboard
```
- SOS emergency button (large red button)
- Geolocation integration
- Quick links to all features

### 4. **Women-Only Forum** (Women Only)
```
http://127.0.0.1:8000/forum
http://127.0.0.1:8000/forum/create
```
- Create discussion posts
- Reply to posts
- Report harassment
- Auto-moderation active

### 5. **Mental Health Chatbot** (All Users)
```
http://127.0.0.1:8000/chatbot
```
- 24/7 AI-powered support
- Chat history storage
- Mental health focused

### 6. **Safe Routes Map** (All Users)
```
http://127.0.0.1:8000/safe-routes
```
- Interactive Leaflet.js map
- Color-coded safety routes (Green/Yellow/Red)
- Report unsafe spots
- Community-verified routes

### 7. **Admin Dashboard** (Admin Only)
```
http://127.0.0.1:8000/admin/dashboard
```
- Real-time SOS alerts
- User statistics
- Route management
- Quick actions

### 8. **Admin SOS History** (Admin Only)
```
http://127.0.0.1:8000/admin/sos-history
```
- All SOS alert history
- Responder map view
- Status tracking
- User information

---

## 👤 Test Credentials

### Admin Account
```
Email:    admin@safeher.local
Password: password
Role:     admin
```
✅ Access: Admin dashboard, SOS tracking, route management

### Woman User
```
Email:    woman@example.com
Password: password
Role:     user
Gender:   female
```
✅ Access: Forum (women-only), Dashboard, Chatbot, Safe Routes

### General User
```
Email:    user@example.com
Password: password
Role:     user
Gender:   male
```
✅ Access: Dashboard, Chatbot, Safe Routes (NOT Forum - women-only)

---

## 🎨 Features Demo

### SOS Alert
1. Go to Dashboard: http://127.0.0.1:8000/dashboard
2. Click the large RED SOS button
3. Allow geolocation access
4. Alert is sent with GPS coordinates
5. Check admin dashboard for real-time alert

### Forum (Women Only)
1. Login as `woman@example.com`
2. Navigate to Forum: http://127.0.0.1:8000/forum
3. Click "Create Post"
4. Add title & description
5. Post is published
6. Reply to posts or report inappropriate content

### Chatbot
1. Login as any user
2. Go to Chatbot: http://127.0.0.1:8000/chatbot
3. Type your message
4. Get AI-powered mental health support
5. View chat history
6. Clear history when done

### Safe Routes
1. Login
2. Go to Safe Routes: http://127.0.0.1:8000/safe-routes
3. View routes on interactive map
4. Routes color-coded by safety:
   - 🟢 Green: Safe (score <5)
   - 🟡 Yellow: Moderate (score 5-15)
   - 🔴 Red: Dangerous (score >15)
5. Click "Report Unsafe Spot" to contribute

### Admin Dashboard
1. Login as `admin@safeher.local`
2. Go to Dashboard: http://127.0.0.1:8000/admin/dashboard
3. View real-time statistics
4. See live SOS alert table
5. Update alert status
6. Manage safe routes

---

## 🔧 Common Commands

```bash
# Start development servers
php artisan serve

# In another terminal:
npm run dev

# Database operations
php artisan migrate          # Run migrations
php artisan db:seed          # Seed test data
php artisan migrate:reset    # Reset database

# Create new admin user
php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin2@safeher.local', 'password' => Hash::make('password'), 'role' => 'admin', 'is_admin' => true, 'gender' => 'female'])

# View all routes
php artisan route:list

# Clear cache
php artisan cache:clear

# View logs
tail -f storage/logs/laravel.log
```

---

## 🔑 API Endpoints (JSON)

### SOS Alert
```bash
POST /sos
Content-Type: application/json
Authorization: Bearer {token}

{
  "latitude": 23.8103,
  "longitude": 90.4125,
  "message": "Need help immediately"
}
```

### Chatbot Message
```bash
POST /chatbot/send-message
Content-Type: application/json
Authorization: Bearer {token}

{
  "message": "I'm feeling anxious"
}
```

### Get Chat History
```bash
GET /chatbot/history
Authorization: Bearer {token}
```

---

## 🌙 Dark Mode

All pages support dark mode:
- Automatically detects system preference
- Manual toggle available in header
- Tailwind CSS 4.0 dark: prefix used throughout

---

## 📊 Real-time Features

### Pusher Integration (Ready for Production)
1. Get Pusher credentials: https://pusher.com
2. Update `.env`:
   ```
   PUSHER_APP_ID=your_app_id
   PUSHER_APP_KEY=your_app_key
   PUSHER_APP_SECRET=your_app_secret
   PUSHER_APP_CLUSTER=mt1
   ```
3. Real-time features activate:
   - Live SOS alerts on admin dashboard
   - Real-time user count updates
   - Live notification delivery

---

## 🤖 OpenAI Integration (Optional)

To enable ChatGPT for chatbot:

1. Get API key: https://platform.openai.com/api-keys
2. Add to `.env`:
   ```
   OPENAI_API_KEY=sk-...
   ```
3. Chatbot will use OpenAI instead of mock responses

---

## 🗺️ Google Maps (Optional)

For advanced heatmaps:

1. Get API key: https://console.cloud.google.com
2. Add to `.env`:
   ```
   GOOGLE_MAPS_API_KEY=AIzaSy...
   ```
3. Heatmap features activate in safe routes

---

## 🐛 Troubleshooting

### Port Already in Use
```bash
# Kill process on port 8000
Get-NetTCPConnection -LocalPort 8000 | Stop-Process -Force
php artisan serve
```

### Database Connection Error
```bash
# Check .env DB credentials
cat .env | grep DB_

# Verify MySQL is running
# Default: localhost, user: root, password: root
```

### Vite Not Loading
```bash
npm install
npm run dev
# Clear browser cache (Ctrl+Shift+Delete)
```

### Reset Everything
```bash
php artisan migrate:reset --force
php artisan migrate
php artisan db:seed
```

---

## 📞 Support

**Project Documentation**: See `PROJECT_COMPLETION.md`  
**Database Schema**: Check `database/migrations/`  
**API Routes**: Run `php artisan route:list`  
**Code Issues**: Check `storage/logs/laravel.log`  

---

## ✨ Next Deployment Steps

1. **Staging**:
   - Upload to staging server
   - Configure production database
   - Enable HTTPS/SSL
   - Test all features

2. **Production**:
   - Get real Pusher credentials
   - Get real OpenAI API key
   - Configure email service
   - Set up automated backups
   - Enable monitoring

3. **Launch**:
   - Promote to production
   - Announce to users
   - Monitor real-time alerts
   - Collect feedback

---

**Last Updated**: December 11, 2025  
**Status**: ✅ READY TO USE & DEPLOY
