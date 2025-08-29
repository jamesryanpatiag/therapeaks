<?php
 
namespace App\Filament\Pages;
 
use Ercogx\FilamentOpenaiAssistant\Pages\OpenaiAssistantPage;
use Ercogx\FilamentOpenaiAssistant\Contracts\OpenaiThreadServicesContract as ThreadServices;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use Livewire\Attributes\On;
use App\Models\Patient;
use App\Models\TreatmentChatPerPatient;
use Auth;
use Log;
 
class ChatPage extends OpenaiAssistantPage
{
    private $patientId;

    public $patients;

    public string $selectedAssistant = 'asst_TQf4VrU9FENkh4FNz7rK5kSx';

    public string $selectedPatientId = '';

    protected $rules = [
        'selectedPatientId' => 'required',
    ];

    public function mount(ThreadServices $threadServices): void
    {
        Log::info($this->selectedPatientId);
        // $this->dispatch('create-new-thread');
    }

    public function selectPatient() {
        $patient = null;
        if ($this->selectedPatientId) {
            $patient = Patient::find($this->selectedPatientId);
        }

        if ($patient) {
            $this->setAssistants();
            $this->setThreads();

            $this->messages[] = [
                'role' => 'user',
                'text' => "Hi Dymphna, Can you assist me?",
            ];

            $this->dispatch('create-new-thread');

        }
    }
    
    public function __construct($patientId = null)
    {
        $this->patients = \App\Models\Patient::all()->pluck('name', 'id')->toArray();
    }

    public function sendMessage(): void
    {
        $this->validate();

        $this->messages[] = [
            'role' => 'user',
            'text' => $this->message,
        ];

        $this->message = '';

        $this->dispatch('chat-updated');

        $this->dispatch($this->selectedThread === 'new-thread' ? 'create-new-thread' : 'update-thread');
    }

    #[On('update-thread')]
    public function updateThread(ThreadServices $threadServices): void
    {
        $this->messages[] = [
            'role' => 'assistant',
            'text' => $threadServices->createMessage(
                $this->selectedAssistant,
                $this->selectedThread,
                $this->lastMessage()
            ),
        ];
        $latestQuestions = $this->messages[count($this->messages)-2];
        $latestAnswer = $this->messages[count($this->messages)-1];

        $treatment = new TreatmentChatPerPatient();
        $treatment->patient_id = $this->selectedPatientId;
        $treatment->user_id = Auth::user()->id;
        $treatment->message = $latestQuestions['text'];
        $treatment->response = $latestAnswer['text'];
        $treatment->save();
        
        $this->dispatch('chat-updated');
    }

    public static function getNavigationLabel(): string
    {
        return "Dymphna";
    }

    

}