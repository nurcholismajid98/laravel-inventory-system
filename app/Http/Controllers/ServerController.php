<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ServerController extends Controller
{
    /**
     * Display the server inventory.
     */
    public function index()
    {
        $servers = Server::all();
        return view('serverData', compact('servers'));
    }

    /**
     * Edit server data
     */
    public function update(Request $request, $id)
    {
        $server = Server::findOrFail($id);
        $server->update($request->only([
            'hostname',
            'type',
            'ip',
            'location',
            'unit_revision',
            'image_version',
            'site_version',
            'installed_probes',
            'owner_project'
        ]));

        return response()->json(['status' => 'success', 'message' => 'Server data updated successfully']);
    }

    /**
     * Delete server data
     */
    public function destroy($id)
    {
        $server = Server::findOrFail($id);
        $qrPath = 'qrcodes/' . $server->serial_number . '.png';

        if (Storage::exists($qrPath)) {
            Storage::delete($qrPath);
        }

        $server->delete();

        return response()->json(['status' => 'success', 'message' => 'Server deleted successfully']);
    }

    /**
     * Generate QR Code
     */
    public function generateQrCode($id)
    {
        $server = Server::findOrFail($id);
        $qrPath = $server->generateQrCode();

        return response()->json(['status' => 'success', 'path' => asset('storage/' . $qrPath)]);
    }

    /**
     * View QR Code
     */
    public function viewQrCode($id)
    {
        $server = Server::findOrFail($id);
        $qrPath = 'qrcodes/' . $server->serial_number . '.png';

        if (Storage::exists($qrPath)) {
            return response()->file(storage_path('app/' . $qrPath));
        }

        return response()->json(['status' => 'error', 'message' => 'QR Code not found'], 404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hostname' => 'required',
            'type' => 'required',
            'ip' => 'required',
            'serial_number' => 'required|unique:servers',
            'location' => 'required',
            'unit_revision' => 'required',
            'image_version' => 'required',
            'site_version' => 'required',
            'installed_probes' => 'required',
            'owner_project' => 'required',
        ]);

        Server::create($validated);

        return response()->json(['message' => 'Data berhasil disimpan']);
    }

    public function search(Request $request)
    {
        $query = Server::query();

        foreach ($request->all() as $field => $value) {
            if (!empty($value)) {
                $query->where($field, 'LIKE', '%' . $value . '%');
            }
        }

        $servers = $query->get();

        return response()->json($servers);
    }

}
