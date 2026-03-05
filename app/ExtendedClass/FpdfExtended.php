<?php

namespace App\ExtendedClass;

use Illuminate\Support\Facades\Request;
use FPDF;

/**
 * fpdf extended are fpdf library with additional method (rotate watermark, GetMultiCellHeight, bulan, terbilang, kekata etc)
 *
 * @author Heru Arief Wijaya <heru@belajararief.com>
 */
class FpdfExtended extends FPDF
{
    const Y_LIMIT = 300;

    const STYLE_TERBILANG_UPPERCASE = 1;
    const STYLE_TERBILANG_LOWERCASE = 2;
    const STYLE_TERBILANG_UPPPER_WORDS = 3;
    const STYLE_TERBILANG_UPPER_SENTENCE = 4;

    public $printAsTte = false;

    /**
     * rotated text
     * to create rotatedtext in pdf header like a watermark
     * example use below
     * function Header(){
     * // masukkan watermark apabila kd_sah == 0
     * if($this->model->kd_sah == 0){
     *      //Put the watermark
     *      $this->SetFont('Arial','B',50);
     *      $this->SetTextColor(163,163,163);
     *      $this->RotatedText(120,170,'DRAFT USULAN',45);
     * }
    }
     */
    var $angle = 0;

    /**
     * Rotate text based on your $angle value
     *
     * @param $angle
     * @param int $x x position
     * @param int $y y position
     * @author hoaaah
     */
    public function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    /**
     * override endpage method to render watermark before page end
     * @author hoaaah
     */
    public function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    /**
     * Render a rotated text
     *
     * Render a rotated text, intentionally build for creating watermark on you page
     * To use with watermark you  can use code below
     * ```php
     * function Header()
     * {
     *     $this->setFont('Arial', 'B', 50);
     *     $this->SetTextColor(163, 163, 163); //rgb color
     *     $this->>RotatedText(120, 170, 'My Watermark', 45);
     * }
     * ```
     *
     * @param float $x
     * @param float $y
     * @param string $txt
     * @param float $angle
     *
     * @author hoaaah
     */
    public function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    /**
     * Memberikan nama bulan untuk keperluan tanggal
     *
     * to create bulan and terbilan usually uses in Laporan
     *
     * @param int $bulan ambil nilai bulan anda, biasanya menggunakan date('n')
     * @return string
     *
     * @author hoaaah
     */
    public function bulan($bulan)
    {
        switch ($bulan) {
            case 1:
                $bulan = "Januari";
                break;
            case 2:
                $bulan = "Februari";
                break;
            case 3:
                $bulan = "Maret";
                break;
            case 4:
                $bulan = "April";
                break;
            case 5:
                $bulan = "Mei";
                break;
            case 6:
                $bulan = "Juni";
                break;
            case 7:
                $bulan = "Juli";
                break;
            case 8:
                $bulan = "Agustus";
                break;
            case 9:
                $bulan = "September";
                break;
            case 10:
                $bulan = "Oktober";
                break;
            case 11:
                $bulan = "November";
                break;
            case 12:
                $bulan = "Desember";
                break;
        }
        return $bulan;
    }


    function convertHariIndonesia($tanggal)
    {
        $hariArray = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        return $hariArray[date('N', strtotime($tanggal))];
    }


    /**
     * Memberikan angka terbilang untuk keperluan angka terbilang
     *
     * @param int $x angka yang ingin di buat terbilang
     * @return string
     *
     * @author hoaaah
     */
    private function kekata($x)
    {
        $x = abs($x);
        $angka = array(
            "", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        );
        $temp = "";
        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = $this->kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = $this->kekata($x / 10) . " puluh" . $this->kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . $this->kekata($x - 100);
        } else if ($x < 1000) {
            $temp = $this->kekata($x / 100) . " ratus" . $this->kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . $this->kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = $this->kekata($x / 1000) . " ribu" . $this->kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = $this->kekata($x / 1000000) . " juta" . $this->kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = $this->kekata($x / 1000000000) . " milyar" . $this->kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = $this->kekata($x / 1000000000000) . " trilyun" . $this->kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    // private function tkoma($x)
    // {
    //     $str = stristr($x, ".");
    //     $ex = explode('.', $x);
    //     $jumlah_ex = count($ex);
    //     if ($jumlah_ex > 1) {
    //         if (($ex[1] / 10) >= 1) {
    //             $a = abs($ex[1]);

    //             $string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan",   "sembilan", "sepuluh", "sebelas");
    //             $temp = "";

    //             $a2 = $ex[1] / 10;
    //             $pjg = strlen($str);
    //             $i = 1;


    //             if ($a >= 1 && $a < 12) {
    //                 $temp .= " " . $string[$a];
    //             } else if ($a > 12 && $a < 20) {
    //                 $temp .= $this->kekata($a - 10) . " belas";
    //             } else if ($a > 20 && $a < 100) {
    //                 $temp .= $this->kekata($a / 10) . " puluh" . $this->kekata($a % 10);
    //             } else {
    //                 if ($a2 < 1) {

    //                     while ($i < $pjg) {
    //                         $char = substr($str, $i, 1);
    //                         $i++;
    //                         $temp .= " " . $string[$char];
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         $temp = "";
    //     }
    //     return $temp;
    // }

    private function tkoma($x)
    {
        $ex = explode(',', $x);
        $jumlah_ex = count($ex);
        $temp = "";
        if ($jumlah_ex > 1) {
            $komapertama = substr($ex[1], 0, 1);
            $komakedua = substr($ex[1], 1, 1);
            $angka = array(
                "nol", "satu", "dua", "tiga", "empat", "lima",
                "enam", "tujuh", "delapan", "sembilan"
            );
            // dd($x);
            if (array_key_exists($komapertama, $angka)) {
                $temp .= $angka[$komapertama];
            }
            if (array_key_exists($komakedua, $angka)) {
                $temp .= ' ' . $angka[$komakedua];
            }
        }
        return $temp;
    }

    /**
     * Memberikan angka terbilang untuk keperluan angka terbilang
     *
     * @param int $x angka yang ingin dikonversi
     * @param int $style style yang ingin di render, untuk referensi silakan lihat pada `PDF::STYLE_TERBILANG_` konstanta
     * @return string
     *
     * @author hoaaah
     */
    function terbilang($x, $style = 4)
    {
        // if (gettype($x) == "string") {
        //     $x = floatval($x);
        // }

        $x = round($x, 2);

        if ($x < 0) {
            $poin = trim($this->tkoma($x));
            $hasil = "minus " . trim($this->kekata($x));
        } else {
            $poin = trim($this->tkoma($x));
            $hasil = trim($this->kekata($x));
        }

        if ($poin) {
            $hasil = $hasil . " koma " . $poin;
        } else {
            $hasil = $hasil;
        }

        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }

    /**
     * getMultiCellHeight to get height of a multicell before render it
     *
     * @param int $w is width of multicell
     * @param int $h is height of multicell row
     * @param string $txt is string text to render
     * @param string|null $border is border applied or not (BTLR) default to null
     * @param string|null $align is align of text (J, L, R) default to J
     *
     * @author hoaaah
     */
    public function GetMultiCellHeight($w, $h, $txt, $border = null, $align = 'J')
    {
        // Calculate MultiCell with automatic or explicit line breaks height
        // $border is un-used, but I kept it in the parameters to keep the call
        //   to this function consistent with MultiCell()
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $height = 0;
        while ($i < $nb) {
            // Get next character
            $c = $s[$i];
            if ($c == "\n") {
                // Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    $this->_out('0 Tw');
                }
                //Increase Height
                $height += $h;
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                // Automatic line break
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    //Increase Height
                    $height += $h;
                } else {
                    if ($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    //Increase Height
                    $height += $h;
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
            } else
                $i++;
        }
        // Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            $this->_out('0 Tw');
        }
        //Increase Height
        $height += $h;

        return $height;
    }

    /**
     * Draws text within a box defined by width = w, height = h, and aligns
     * the text vertically within the box ($valign = M/B/T for middle, bottom, or top)
     * Also, aligns the text horizontally ($align = L/C/R/J for left, centered, right or justified)
     * drawTextBox uses drawRows
     *
     * This function is provided by TUFaT.com
     */
    function drawTextBox($strText, $w, $h, $align = 'L', $valign = 'T', $border = true)
    {
        $xi = $this->GetX();
        $yi = $this->GetY();

        $hrow = $this->FontSize;
        $textrows = $this->drawRows($w, $hrow, $strText, 0, $align, 0, 0, 0);
        $maxrows = floor($h / $this->FontSize);
        $rows = min($textrows, $maxrows);

        $dy = 0;
        if (strtoupper($valign) == 'M')
            $dy = ($h - $rows * $this->FontSize) / 2;
        if (strtoupper($valign) == 'B')
            $dy = $h - $rows * $this->FontSize;

        $this->SetY($yi + $dy);
        $this->SetX($xi);

        $this->drawRows($w, $hrow, $strText, 0, $align, false, $rows, 1);

        if ($border)
            $this->Rect($xi, $yi, $w, $h);
    }

    function drawRows($w, $h, $txt, $border = 0, $align = 'J', $fill = false, $maxline = 0, $prn = 0)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $b = 0;
        if ($border) {
            if ($border == 1) {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            } else {
                $b2 = '';
                if (is_int(strpos($border, 'L')))
                    $b2 .= 'L';
                if (is_int(strpos($border, 'R')))
                    $b2 .= 'R';
                $b = is_int(strpos($border, 'T')) ? $b2 . 'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        while ($i < $nb) {
            //Get next character
            $c = $s[$i];
            if ($c == "\n") {
                //Explicit line break
                if ($this->ws > 0) {
                    $this->ws = 0;
                    if ($prn == 1) $this->_out('0 Tw');
                }
                if ($prn == 1) {
                    $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                }
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
                if ($maxline && $nl > $maxline)
                    return substr($s, $i);
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                //Automatic line break
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                    if ($this->ws > 0) {
                        $this->ws = 0;
                        if ($prn == 1) $this->_out('0 Tw');
                    }
                    if ($prn == 1) {
                        $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
                    }
                } else {
                    if ($align == 'J') {
                        $this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
                        if ($prn == 1) $this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
                    }
                    if ($prn == 1) {
                        $this->Cell($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
                    }
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if ($border && $nl == 2)
                    $b = $b2;
                if ($maxline && $nl > $maxline)
                    return substr($s, $i);
            } else
                $i++;
        }
        //Last chunk
        if ($this->ws > 0) {
            $this->ws = 0;
            if ($prn == 1) $this->_out('0 Tw');
        }
        if ($border && is_int(strpos($border, 'B')))
            $b .= 'B';
        if ($prn == 1) {
            $this->Cell($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
        }
        $this->x = $this->lMargin;
        return $nl;
    }

    /**
     * create a paragraph text
     * will return paragraph without rendering it
     * you can get how many lines this text will take
     * $textLines = $pdf->WordWrap($text, $maxWidth); // output for example 8
     * @param string $text
     * @param int $maxWidth
     */
    function WordWrap(&$text, $maxwidth)
    {
        $text = trim($text);
        if ($text === '')
            return 0;
        $space = $this->GetStringWidth(' ');
        $lines = explode("\n", $text);
        $text = '';
        $count = 0;

        foreach ($lines as $line) {
            $words = preg_split('/ +/', $line);
            $width = 0;

            foreach ($words as $word) {
                $wordwidth = $this->GetStringWidth($word);
                if ($wordwidth > $maxwidth) {
                    // Word is too long, we cut it
                    for ($i = 0; $i < strlen($word); $i++) {
                        $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                        if ($width + $wordwidth <= $maxwidth) {
                            $width += $wordwidth;
                            $text .= substr($word, $i, 1);
                        } else {
                            $width = $wordwidth;
                            $text = rtrim($text) . "\n" . substr($word, $i, 1);
                            $count++;
                        }
                    }
                } elseif ($width + $wordwidth <= $maxwidth) {
                    $width += $wordwidth + $space;
                    $text .= $word . ' ';
                } else {
                    $width = $wordwidth + $space;
                    $text = rtrim($text) . "\n" . $word . ' ';
                    $count++;
                }
            }
            $text = rtrim($text) . "\n";
            $count++;
        }
        $text = rtrim($text);
        return $count;
    }

    /**
     * Membuat tanggal terbilang
     * @param string $tanggal
     * @param int $format, terdiri dari seperti di bawah ini
     * Format:
     * ---- 1 => 20 Mei 2019
     * ---- 2 => Selasa, 20 Mei 2019
     * ---- 3 => tanggal 10 bulan Mei Tahun 2019
     * ---- 4 => tanggal sepuluh bulan mei tahun dua ribu sembilan belas
     */
    public function tanggalTerbilang($tanggal, $format)
    {
        switch ($format) {
            case 1:
                return date("d", strtotime($tanggal)) . " " . $this->bulan(date('m', strtotime($tanggal))) . " " . date('Y', strtotime($tanggal));
                break;
            case 2:
                return ucwords($this->convertHariIndonesia($tanggal)) . ", " . date("d", strtotime($tanggal)) . " " . $this->bulan(date('m', strtotime($tanggal))) . " " . date('Y', strtotime($tanggal));
                break;

            default:
                # code...
                break;
        }
    }

    function SetDash($black = null, $white = null)
    {
        if ($black !== null)
            $s = sprintf('[%.3F %.3F] 0 d', $black * $this->k, $white * $this->k);
        else
            $s = '[] 0 d';
        $this->_out($s);
    }

    // WRITE HTML

    protected $B = 0;
    protected $I = 0;
    protected $U = 0;
    protected $HREF = '';

    function WriteHTML($html)
    {
        // HTML parser
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                // Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                else
                    $this->Write(5, $e);
            } else {
                // Tag
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    // Extract attributes
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $attr = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $attr[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $attr);
                }
            }
        }
    }

    function OpenTag($tag, $attr)
    {
        // Opening tag
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $attr['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
    }

    function CloseTag($tag)
    {
        // Closing tag
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
    }

    function SetStyle($tag, $enable)
    {
        // Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s) {
            if ($this->$s > 0)
                $style .= $s;
        }
        $this->SetFont('', $style);
    }

    function PutLink($URL, $txt)
    {
        // Put a hyperlink
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }

    /**
     * Check if page already reach limit of the page
     * Usually combine with `$this->getMultiCellHeight` if you use multicell, or just fill $ymaxAfter with current $x
     * example use with getMultiCellHeight
     * ```php
     * $yMaxAfter = max(
     *     $pdf->getMultiCellHeight($w, $h, $data->text),
     *     $myFixedYPosition
     * );
     * if ($pdf->checkIfPageExceed($yMaxAfter) $pdf->breakPage();
     * ```
     *
     * @param $yMaxAfter
     * @param int $pageYLimit
     * @return bool
     *
     * @author hoaaah
     */
    function checkIfPageExceed($yMaxAfter, $pageYLimit = self::Y_LIMIT)
    {
        if ($pageYLimit >= $this->GetPageHeight()) {
            $pageYLimit = ($this->GetPageHeight() - 30);
        }
        if (($yMaxAfter + 5) > $pageYLimit) return true;
        return false;
    }

    /**
     * Breakpage and createBrakePageColumnLine
     * usually use when combine with table with multicell
     *
     * @param float $x x position
     * @param array $w width array
     * @param float $yst first y position
     * @param float $ylst last y position
     *
     * @author hoaaah
     */
    function breakPage($x, $w, $yst, $ylst)
    {
        $this->createBreakPageColumnLine($x, $w, $yst, $ylst);
        $this->AddPage();
    }


    /**
     * create brake page column line
     * usually use when combine with table with multicell
     *
     * @param float $x x position
     * @param array $w width array
     * @param float $yst first y position
     * @param float $ylst last y position
     *
     * @author hoaaah
     */
    function createBreakPageColumnLine($x, $w, $yst, $ylst)
    {
        $countW = count($w);
        if ($countW >= 1) $this->Rect($x, $yst, $w[0], $ylst);
        if ($countW >= 2) $this->Rect($x + $w[0], $yst, $w[1], $ylst);
        if ($countW >= 3) $this->Rect($x + $w[0] + $w[1], $yst, $w[2], $ylst);
        if ($countW >= 4) $this->Rect($x + $w[0] + $w[1] + $w[2], $yst, $w[3], $ylst);
        if ($countW >= 5) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3], $yst, $w[4], $ylst);
        if ($countW >= 6) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4], $yst, $w[5], $ylst);
        if ($countW >= 7) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5], $yst, $w[6], $ylst);
        if ($countW >= 8) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5] + $w[6], $yst, $w[7], $ylst);
        if ($countW >= 9) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5] + $w[6] + $w[7], $yst, $w[8], $ylst);
        if ($countW >= 10) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5] + $w[6] + $w[7] + $w[8], $yst, $w[9], $ylst);
        if ($countW >= 11) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5] + $w[6] + $w[7] + $w[8] + $w[9], $yst, $w[10], $ylst);
        if ($countW >= 12) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5] + $w[6] + $w[7] + $w[8] + $w[9] + $w[10], $yst, $w[11], $ylst);
        if ($countW >= 13) $this->Rect($x + $w[0] + $w[1] + $w[2] + $w[3] + $w[4] + $w[5] + $w[6] + $w[7] + $w[8] + $w[9] + $w[10] + $w[11], $yst, $w[12], $ylst);
    }

    /**
     * default footer style
     * used in all report documents
     *
     * @param string $qrCodeText url to display in qrCode
     *
     * @author vlv
     */
    function pageFooterTTE($qrCodeText = null)
    {
        $yQr = $this->GetPageWidth() - 20; // 191; // when potrait

        if ($qrCodeText == null) $qrCodeText = Request::fullUrl();

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Line(10, ($this->GetY() - 3), $this->GetPageWidth() - 20, ($this->GetY() - 3));
        $this->Line(10, ($this->GetY() - 2), $this->GetPageWidth() - 20, ($this->GetY() - 2));

        $this->Image(asset('images/bsre.png'), 10, $this->GetY() - 1, 20, 0, 'PNG');
        $this->SetX(30);
        $this->Cell(47, 4, '- UU ITE No 11 Tahun 2008 Pasal 5 Ayat 1', 0, 0, 'L');
        $this->Cell(0, 4, 'Printed By Forsa BLUD | ' . $this->PageNo() . '/{nb}         ', 0, 0, 'R');
        $this->Image(route('qr', ['text' => $qrCodeText]), $yQr, $this->getY() - 10, 15, 0, 'PNG');
        $this->ln(3);
        $this->SetX(30);
        $this->Cell(117, 4, '"Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah."', 0, 0, 'L');
        $this->ln(3);
        $this->SetX(30);
        $this->Cell(107, 4, '- Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan oleh Balai Sertifikasi Elektronik (BSrE), Badan Siber dan Sandi Negara (BSSN)', 0, 0, 'L');
        // $this->ln(3);
    }

    /**
     * default footer style
     * used in all report documents
     *
     * @param string $qrCodeText url to display in qrCode
     *
     * @author vlv
     */
    function pageFooterNonTTE()
    {
        $yQr = $this->GetPageWidth() - 20; // 191; // when potrait

        // if ($this->GetPageWidth() > 216) $yQr = 300;

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Line(10, ($this->GetY() - 3), $this->GetPageWidth() - 20, ($this->GetY() - 3));
        $this->Line(10, ($this->GetY() - 2), $this->GetPageWidth() - 20, ($this->GetY() - 2));

        $this->Cell(0, 4, 'Printed By Forsa BLUD | ' . $this->PageNo() . '/{nb}   ', 0, 0, 'R');
    }


    /**
     * accountingNumberFormat
     *
     * @param  float $number
     * @param  int|null $dec
     * @param  string|null $minusFormat accounting for () minus format, number for negative sign
     * @return void
     */
    public function accountingNumberFormat($number, $dec = 2, $minusFormat = 'accounting')
    {
        if (($number < 0) && ($minusFormat == 'accounting')) {
            return '(' . number_format(-$number, $dec, ',', '.') . ')';
        }
        return number_format($number, $dec, ',', '.');
    }
}
