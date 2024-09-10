<?php

namespace Modules\VpsManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Modules\VpsManager\Models\VpsInstance;
use Carbon\Carbon;

class VpsManagerController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.upcloud.com/1.3/',
            'auth' => [config('vpsmanager.upcloud_username'), config('vpsmanager.upcloud_password')]
        ]);
    }

    public function index()
    {
        $instances = VpsInstance::all();
        return view('vpsmanager::index', compact('instances'));
    }

    public function updateInstances()
    {
        $response = $this->client->get('server');
        $servers = json_decode($response->getBody(), true)['servers']['server'];

        foreach ($servers as $server) {
            if (in_array('VPS', $server['tags'])) {
                VpsInstance::updateOrCreate(
                    ['cid' => $server['cid']],
                    [
                        'full_name' => $server['full_name'],
                        'email' => $server['email'],
                        'ip_address' => $server['ip_addresses']['ip_address'][0]['address'],
                        'creation_date' => $server['created'],
                        'status' => $server['state'],
                        'expiration_date' => $server['expiration_date'],
                    ]
                );
            }
        }

        return redirect()->route('vpsmanager.index')->with('success', 'VPS instances updated successfully.');
    }

    public function restart(Request $request, $id)
    {
        $instance = VpsInstance::findOrFail($id);
        $response = $this->client->post("server/{$instance->cid}/restart");

        if ($response->getStatusCode() == 200) {
            return redirect()->route('vpsmanager.index')->with('success', 'VPS restarted successfully.');
        }

        return redirect()->route('vpsmanager.index')->with('error', 'Failed to restart VPS.');
    }

    public function terminate(Request $request, $id)
    {
        $instance = VpsInstance::findOrFail($id);
        $response = $this->client->delete("server/{$instance->cid}");

        if ($response->getStatusCode() == 204) {
            $instance->delete();
            return redirect()->route('vpsmanager.index')->with('success', 'VPS terminated successfully.');
        }

        return redirect()->route('vpsmanager.index')->with('error', 'Failed to terminate VPS.');
    }

    public function reportIssue(Request $request, $id)
    {
        $instance = VpsInstance::findOrFail($id);
        // Implement logic to report an issue to the tech team
        // This could involve creating a ticket in ticketing system
        // or sending an email to the tech team

        return redirect()->route('vpsmanager.index')->with('success', 'Issue reported to tech team.');
    }

    public function sendNotice(Request $request, $id)
    {
        $instance = VpsInstance::findOrFail($id);
        // Implement logic to send a notice to the client
        // This could involve sending an email or SMS to the client

        return redirect()->route('vpsmanager.index')->with('success', 'Notice sent to client.');
    }

    public function extendExpiration(Request $request, $id)
    {
        $instance = VpsInstance::findOrFail($id);
        $days = $request->input('days', 7);
        $newExpirationDate = Carbon::parse($instance->expiration_date)->addDays($days);

        // Update the expiration date in UpCloud account
        // This is a placeholder as UpCloud API doesn't have a direct method for this
        // Might need to implement this differently based on actual requirements

        $instance->expiration_date = $newExpirationDate;
        $instance->save();

        return redirect()->route('vpsmanager.index')->with('success', "VPS expiration extended by {$days} days.");
    }
}