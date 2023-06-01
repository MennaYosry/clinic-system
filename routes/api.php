<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmrController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\TokenController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//patient's Routes
Route::post('register-patient', [PatientController::class, 'register']);
Route::post('login-patient', [PatientController::class, 'login']);
Route::post('logout-patient', [PatientController::class, 'logout']);
Route::get('show-patient/{id}', [PatientController::class, 'show']);
Route::post('make-reservation',[ReservationController::class,'make_reservation']);
Route::post('emr-insertion',[EmrController::class,'emr_insertion']);
Route::get('patient-questions/{id}', [PatientController::class, 'getPatientQuestions']);
Route::post('make-question',[QuestionController::class,'make_question']);
Route::post('question-destroy/{id}', [QuestionController::class, 'questiondestroy']);
Route::get('patient-reservations/{id}', [PatientController::class, 'getPatientreservation']);
Route::get('showdoctor-profile/{id}', [DoctorController::class, 'show_doctor_profile']);
Route::get('reply/{questionId}', [ReplyController::class, 'getReply']);
Route::post('update_patient_info/{id}', [PatientController::class, 'update_patient_info']);
Route::post('patient-destroy/{id}', [PatientController::class, 'patientdestroy']);
Route::post('update-emr/{id}',[EmrController::class,'update_emr']);
Route::post('delete-reservation/{id}',[ReservationController::class,'reservationdestroy']);



//doctor's Routes 
Route::post('register-doctor', [DoctorController::class, 'register']);
Route::post('login-doctor', [DoctorController::class, 'login']);
Route::post('logout-doctor', [DoctorController::class, 'logout']);
Route::get('show-doctor/{id}', [DoctorController::class, 'show']);
Route::get('doctors/{id}/patients', [PatientController::class, 'getPatientsAndEMRs']);
Route::get('doctor-questions/{id}', [DoctorController::class, 'getDoctorQuestions']);
Route::get('doctor-reservations/{id}', [DoctorController::class, 'getdoctorreservation']);
Route::post('make-reply', [ReplyController::class, 'make_reply']);
Route::get('patients-emr/{id}', [PatientController::class, 'getPatientAndEmr']);
Route::post('doctor-report/{id}', [EmrController::class, 'insertdoctor_report']);
Route::post('delete-reservation/{id}',[ReservationController::class,'reservationdestroy']);
Route::post('update_doctor_info/{id}', [DoctorController::class, 'update_doctor_info']);
Route::post('update_doctor-report/{id}', [EmrController::class, 'insertdoctor_report']);
//admin's Routes 
//On Department
Route::post('department-store', [DepartmentController::class, 'adminstore']);
Route::post('department-update/{id}', [DepartmentController::class, 'adminupdate']);
Route::post('department-destroy/{id}', [DepartmentController::class, 'admindestroy']);
Route::get('department-list',[DepartmentController::class,'adminshow']);
//On Doctor
Route::post('doctor-store', [DoctorController::class, 'adminstore']);
Route::post('doctor-update/{id}', [DoctorController::class, 'adminupdate']);
Route::post('doctor-destroy/{id}', [DoctorController::class, 'admindestroy']);
Route::get('doctor-list',[DoctorController::class,'adminshow']);
//youssif work :P
Route::get('csrf-token', [TokenController::class, 'getCsrfToken']);