<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = [];

    public function treatmentChatPerPatients() {
        return $this->hasMany(TreatmentChatPerPatient::class, 'patient_id', 'id');
    }

    public function documents() {
        return $this->hasMany(PatientDocument::class, 'patient_id', 'id');
    }
}
