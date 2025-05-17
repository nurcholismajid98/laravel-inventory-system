<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'hostname', 'type', 'ip', 'serial_number', 
        'location', 'unit_revision', 'image_version', 
        'site_version', 'installed_probes', 'owner_project'
    ];

    public function generateQrCode()
    {
        $qrData = route('server.show', $this->id);
        $qrPath = 'qrcodes/' . $this->serial_number . '.png';

        $qrCode = QrCode::format('png')->size(200)->generate($qrData);
        Storage::put($qrPath, $qrCode);

        return $qrPath;
    }
}
