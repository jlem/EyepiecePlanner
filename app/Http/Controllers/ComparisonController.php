<?php

namespace EPP\Http\Controllers;

use EPP\Eyepiece\EyepieceRepository;

class ComparisonController extends Controller
{
    /**
     * @var EyepieceRepository
     */
    private $eyepieceRepository;

    public function __construct(EyepieceRepository $eyepieceRepository)
    {
        $this->eyepieceRepository = $eyepieceRepository;
    }

    public function compare()
    {
        $eyepieces = $this->eyepieceRepository->getJSONList();

        return view('compare.compare', compact('eyepieces'));
    }
}
