<?php

namespace App\Droit\Generate\Pdf;

interface PdfGeneratorInterface
{
    public function setMsg($message,$type);
    public function factureOrder($order_id);
    public function make($document, $model, $rappel = null);
    public function makeAbo($document, $model, $rappel = null);
    public function getData($document);
}