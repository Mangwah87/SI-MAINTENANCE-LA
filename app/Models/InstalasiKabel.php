// app/Models/InstalasiKabel.php

class InstalasiKabel extends Model
{
    // ... properti lainnya ...

    // Relasi untuk Detail Item Pemeriksaan
    public function details()
    {
        // Ganti ModelName dengan nama Model yang menyimpan detail item Anda
        return $this->hasMany(DetailInstalasiKabel::class); 
    }
    
    // Relasi untuk Catatan dan Pelaksana
    public function pelaksanas()
    {
        // Ganti ModelName dengan nama Model yang menyimpan data pelaksana Anda
        return $this->hasMany(PelaksanaInstalasiKabel::class); 
    }
}