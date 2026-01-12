<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /* =========================
     * LIST SOAL PER KATEGORI
     * ========================= */
    public function index(Category $category)
    {
        $questions = Question::where('category_id', $category->id)
            ->latest()
            ->paginate(6);

        return view('hrd.questions.index', compact('category','questions'));
    }

    /* =========================
     * PILIH TIPE SOAL
     * ========================= */
    public function chooseType(Category $category)
    {
        return view('hrd.questions.choose', compact('category'));
    }

    public function createChoice(Category $category)
    {
        return view('hrd.questions.create_choice', compact('category'));
    }

    public function createEssay(Category $category)
    {
        return view('hrd.questions.create_essay', compact('category'));
    }

    /* =========================
     * SIMPAN SOAL
     * ========================= */
    public function store(Request $request, Category $category)
    {
        if ($request->type === 'choice') {

            $data = $request->validate([
                'type'           => 'required|in:choice',
                'question_text'  => 'required|min:3',
                'question_image' => 'nullable|image|max:2048',

                'option_a' => 'required',
                'option_b' => 'required',
                'option_c' => 'required',
                'option_d' => 'required',
                'option_e' => 'required',

                'correct_answer' => 'required|in:A,B,C,D,E',
            ]);

            $data['options'] = [
                'A' => $data['option_a'],
                'B' => $data['option_b'],
                'C' => $data['option_c'],
                'D' => $data['option_d'],
                'E' => $data['option_e'],
            ];

            unset(
                $data['option_a'],
                $data['option_b'],
                $data['option_c'],
                $data['option_d'],
                $data['option_e']
            );

        } else {
            // URAIAN
            $data = $request->validate([
                'type'           => 'required|in:essay',
                'question_text'  => 'required|min:3',
                'question_image' => 'nullable|image|max:2048',
                'correct_answer' => 'nullable|string',
            ]);

            $data['options'] = null;
        }

        if ($request->hasFile('question_image')) {
            $data['question_image'] =
                $request->file('question_image')->store('questions','public');
        }

        $data['category_id'] = $category->id;

        Question::create($data);

        return redirect()
            ->route('hrd.questions.index',$category->id)
            ->with('success','Soal berhasil ditambahkan');
    }

    /* =========================
     * EDIT
     * ========================= */
    public function edit(Question $question)
    {
        if ($question->type === 'choice') {
            return view('hrd.questions.edit_choice', compact('question'));
        }

        return view('hrd.questions.edit_essay', compact('question'));
    }

    /* =========================
     * UPDATE
     * ========================= */
    public function update(Request $request, Question $question)
    {
        if ($request->type === 'choice') {

            $data = $request->validate([
                'type'           => 'required|in:choice',
                'question_text'  => 'required|min:3',
                'question_image' => 'nullable|image|max:2048',

                'option_a' => 'required',
                'option_b' => 'required',
                'option_c' => 'required',
                'option_d' => 'required',
                'option_e' => 'required',

                'correct_answer' => 'required|in:A,B,C,D,E',
            ]);

            $data['options'] = [
                'A' => $data['option_a'],
                'B' => $data['option_b'],
                'C' => $data['option_c'],
                'D' => $data['option_d'],
                'E' => $data['option_e'],
            ];

            unset(
                $data['option_a'],
                $data['option_b'],
                $data['option_c'],
                $data['option_d'],
                $data['option_e']
            );

        } else {

            $data = $request->validate([
                'type'           => 'required|in:essay',
                'question_text'  => 'required|min:3',
                'question_image' => 'nullable|image|max:2048',
                'correct_answer' => 'nullable|string',
            ]);

            $data['options'] = null;
        }

        if ($request->hasFile('question_image')) {

            if ($question->question_image &&
                Storage::disk('public')->exists($question->question_image)) {
                Storage::disk('public')->delete($question->question_image);
            }

            $data['question_image'] =
                $request->file('question_image')->store('questions','public');
        }

        $question->update($data);

        return redirect()
            ->route('hrd.questions.index',$question->category_id)
            ->with('success','Soal berhasil diperbarui');
    }

    /* =========================
     * PREVIEW
     * ========================= */
    public function preview(Question $question)
    {
        return view('hrd.questions.preview', compact('question'));
    }

    /* =========================
     * DELETE
     * ========================= */
    public function destroy(Question $question)
    {
        if ($question->question_image &&
            Storage::disk('public')->exists($question->question_image)) {
            Storage::disk('public')->delete($question->question_image);
        }

        $question->delete();

        return back()->with('success','Soal dihapus');
    }
}
