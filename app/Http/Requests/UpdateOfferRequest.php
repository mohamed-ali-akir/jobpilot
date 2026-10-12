<?php

namespace App\Http\Requests;

use App\Models\Offer;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'company_id' => ['required', 'exists:companies,id'],
            'type_contrat' => ['required', Rule::in(Offer::TYPES_CONTRAT)],
            'date_debut' => ['required', 'date'],
            'salaire' => ['required', 'integer', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Messages d'erreur en français.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le titre de l\'offre est obligatoire.',
            'company_id.required' => 'Choisissez une entreprise.',
            'company_id.exists' => 'Cette entreprise n\'existe pas.',
            'type_contrat.required' => 'Choisissez un type de contrat.',
            'type_contrat.in' => 'Type de contrat invalide.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début n\'est pas valide.',
            'salaire.required' => 'Le salaire est obligatoire.',
            'salaire.integer' => 'Le salaire doit être un nombre entier.',
            'salaire.min' => 'Le salaire ne peut pas être négatif.',
            'address.required' => 'La localisation est obligatoire.',
        ];
    }
}
