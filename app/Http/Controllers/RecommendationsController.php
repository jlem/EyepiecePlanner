<?php

namespace EPP\Http\Controllers;

use EPP\Eyepiece\EyepieceRepository;

class RecommendationsController extends Controller
{
    /**
     * @var EyepieceRepository
     */
    private $eyepieceRepository;

    public function __construct(EyepieceRepository $eyepieceRepository)
    {
        $this->eyepieceRepository = $eyepieceRepository;
    }

    public function showForm()
    {
        return view('recommendations.form');
    }

    public function getRecommendations()
    {
    }
}
