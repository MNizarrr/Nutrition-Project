# TODO: Implement User Exercise Session Feature

## Migration
- [ ] Create migration for `user_exercise_sessions` table (user_id, physical_activity_id, duration_minutes, calories_burned, started_at, finished_at)

## Model
- [ ] Create `UserExerciseSession` model with relationships to User and PhysicalActivity

## Controller
- [ ] Create `UserExerciseController` with methods:
  - [ ] `start($activityId)`: Display start page
  - [ ] `finish(Request $request)`: Store session and redirect to complete
  - [ ] `complete($sessionId)`: Display completion page
  - [ ] `exportPDF($sessionId)`: Generate and download PDF

## Views
- [x] Create `resources/views/user/exercise/start.blade.php`: Duration selector with JS calculation
- [x] Create `resources/views/user/exercise/complete.blade.php`: Summary and PDF export button

## Routes
- [x] Add routes in `routes/web.php` under auth middleware:
  - [x] GET /exercise/start/{activityId} -> start
  - [x] POST /exercise/finish -> finish
  - [x] GET /exercise/complete/{sessionId} -> complete
  - [x] GET /exercise/pdf/{sessionId} -> exportPDF

## Updates
- [ ] Update `resources/views/home.blade.php`: Change "Mulai Program" href to route with activity ID

## Dependencies
- [x] Install `barryvdh/laravel-dompdf` via composer

## Testing
- [x] Run migration
- [x] Test flow: start program -> select duration -> finish -> view completion -> download PDF
