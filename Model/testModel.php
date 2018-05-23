<?php
                       
                       
                        $csvFile = file('descripteur_essai.csv');
                        $data = [];
                        foreach ($csvFile as $line) {
                            $data[] = str_getcsv($line);
                        }
                        
                        $v = $data[2];
                            for($i=0;$i<count($v);$i++)
                            {
                                if($v[$i]=="")
                                {
                                    echo "| vide |";
                                }
                                else {
                                    echo "| $v[$i] |";
                                }
                            
                             }
                        