<?php

namespace EPP\Http\Controllers;

use EPP\Domain\Model\Eyepiece\EyepieceRepository;

class ComparisonController extends Controller
{
    /**
     * @var \EPP\Domain\Model\Eyepiece\EyepieceRepository
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
