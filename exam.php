<?php 

    //STRUKTURA WSZYSTKICH DANYCH WEJSCIOWYCH , PORÓWNAWCZYCH, ORAZ INSTRUKCJI
    class _STRUCT{
        public  $input = '(((*))(((((*)))(*))))';
        public  $upstairs = ')';
        public  $downstairs = '(';
        public  $hoard = '*';
        public  $level = -1;
        public  $stack = array();
    }
    class _KERNEL extends _STRUCT{
        //Alternatywna funkcja do   juz wbudowaniej funkcji CHUNK_SPLIT(String,INT,CHAR)
        public function Chunk($input,$delimiter)
        {
            $max = strlen($input); //LICZE ILE WYNOSI ZBIOR WSZYSTKICH LITER W DANYCH WEJSCIOWYCH
            $out = '';
            for($i=0; $i < $max;$i++) //PĘTLA
            {
                 $out .= $input[$i].$delimiter; //DO KAZDEJ LITERY Z DANYCH WEJSCIOWYCH DODAJE PRZECINEK ',' ZEBY W PRZYSZŁOŚCI 
                                                //UTWORZYĆ TABLICE GDZIE BEDĘ SEGREGOWAĆ INSTRUKCJE , np : INDEX => 1 
                                                                                                    //     CIĄG => )
                                                                                                    //      POZIOM = -4
            }
            return $out;
        }
        public function Operator()
        {
            $split = explode(',',$this->Chunk($this->input,',')); //OTRZYMUJE KAZDĄ LITERE PO PRZECINKU ','
            for($i=0; $i<count($split); $i++)// PĘTLA
            {
                $this->stack[$i] = array("INDEX"=>$i); //WGRYWAM INDEKS
                $this->stack[$i] += array("CIĄG" => $split[$i]); // WGRYWAM CIĄG
                if($this->level < count($split))
                {
                    //TUTAJ NADCHODZY SEGREGACJA, CO DAJE NAM INFORMACJE O TYM ZE PORUSZAMY SIE W KIERUNKU DOLNEGO PIĘTRA
                    if($split[$i] === $this->downstairs){
                        $this->stack[$i] += array("POZIOM" => $this->level--);  
                    }
                    else{
                        //PORUSZAMY SIE W KIERUNKU GÓRNEGO PIĘTRA
                        $this->stack[$i] += array("POZIOM" => $this->level++);  
                    }
                }
            }
            return $this->stack; //ZWRACAM CAŁĄ TABLICE ZAWIERAJĄCA DANE O INSTRUKCJACH OPISANYCH POWYŻEJ
        }
    }

    function main()
    {
        $struct = new _STRUCT();
        $core = new _KERNEL();
        
        foreach($core->operator() as $box) // ZACZYNA SIĘ INICIALIZACJA TABLICY
        {
           
            if($box["CIĄG"] ===  $struct->hoard && $box["INDEX"] > 0) // SPRWADZAM CZY CIĄG JEST RÓWNY * (SKARB) I CZY PRZYPYSANY INDEKS JEST WIEKSZY NIZ 0
            {
                return "NAJMNIEJSZY INDEKS WYNOSI -> " .min(array($box["INDEX"])); //ZAPOMOCĄ FUNKCJI min() ZWRACAM NAJMNIEJSZĄ WARTOŚĆ
            }
        }
    }

    echo main().PHP_EOL;
?>