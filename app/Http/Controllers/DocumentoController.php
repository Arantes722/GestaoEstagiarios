<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        $query = Documento::query()
            ->with('utilizador')
            ->where('utilizador_id', $userId);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('tipo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        if ($request->filled('date_start')) {
            $query->whereDate('created_at', '>=', $request->input('date_start'));
        }

        if ($request->filled('date_end')) {
            $query->whereDate('created_at', '<=', $request->input('date_end'));
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $documentos = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalDocumentos = Documento::where('utilizador_id', $userId)->count();
        $totalAceites = Documento::where('utilizador_id', $userId)->where('status', 'aprovado')->count();
        $totalRecusadas = Documento::where('utilizador_id', $userId)->where('status', 'recusado')->count();
        $totalPendentes = Documento::where('utilizador_id', $userId)->where('status', 'pendente')->count();

        return view('documentos.index', compact(
            'documentos',
            'totalDocumentos',
            'totalAceites',
            'totalRecusadas',
            'totalPendentes'
        ));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|string|in:justificacao,baixa,declaracao,outro',
            'ficheiro' => 'required|file|mimes:pdf|max:5120',
        ], [
            'ficheiro.max' => 'O ficheiro não pode ter mais de 5MB.',
            'ficheiro.mimes' => 'Apenas ficheiros PDF são permitidos.',
            'ficheiro.required' => 'É obrigatório enviar um ficheiro.',
        ]);

        try {
            $file = $request->file('ficheiro');
            $path = $file->store('documentos', 'public');

            Documento::create([
                'titulo' => $validated['titulo'],
                'tipo' => $validated['tipo'],
                'tamanho' => $file->getSize(),
                'utilizador_id' => auth()->id(),
                'caminho' => $path,
                'status' => 'pendente',
            ]);

            return redirect()->route('documentos.index')
                ->with('message', ['type' => 'success', 'text' => 'Documento enviado com sucesso e está pendente de aprovação.']);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['ficheiro' => 'Erro ao guardar o ficheiro. Por favor, tente novamente.'])
                ->with('message', ['type' => 'error', 'text' => 'Erro ao submeter o documento.']);
        }
    }


    public function download($id)
    {
        $documento = Documento::findOrFail($id);

        if (!Storage::disk('public')->exists($documento->caminho)) {
            abort(404);
        }

        return Storage::disk('public')->download($documento->caminho, $documento->titulo . '.pdf');
    }

    public function cancelar($id)
    {
        $documento = Documento::where('id', $id)
            ->where('status', 'pendente')
            ->where('utilizador_id', auth()->id())
            ->firstOrFail();

        if (Storage::disk('public')->exists($documento->caminho)) {
            Storage::disk('public')->delete($documento->caminho);
        }

        $documento->delete();

        return redirect()->route('documentos.index')
            ->with('message', ['type' => 'success', 'text' => 'Upload do documento cancelado.']);
    }
}
