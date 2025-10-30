# TODO: Enhance BMI Calculator with Modal and Teacher Progress

## 1. Update BMI Calculator View
- [x] Add a modal to display BMI result, category, and "Simpan" / "Batal" buttons.
- [x] Implement JavaScript to calculate BMI on form submit, show modal, handle save/cancel actions.
- [x] Ensure modal appears after calculation without page reload.

## 2. Update Routes
- [x] Change teacher progress route from closure to controller method in routes/web.php.

## 3. Update TeacherFeedbackController
- [x] Add `progress` method to fetch and display user BMI data for teachers.

## 4. Update Teacher Progress View
- [x] Modify resources/views/teacher/progress.blade.php to display a table of users with their latest BMI records.

## 5. Testing
- [ ] Test BMI calculator: Enter values, verify modal shows correct result, save adds to history, cancel does nothing.
- [ ] Check history page: Confirm saved records appear.
- [ ] Check teacher progress: Ensure teachers see user BMI records.
- [ ] Verify authentication and permissions.
