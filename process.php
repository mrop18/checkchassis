<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'components/_dbconnect.php';

    $searchedChassisNumber = $_POST['chassisNumber'];

    // Decode the chassis number and check for errors
    decodeChassis($searchedChassisNumber);

    // Check if there is an error in the session
    if (isset($_SESSION['chassisResult']['error'])) {
        // Do not insert into the database, just store the error in the session
        // The error is already stored in $_SESSION['chassisResult']
    } else {
        // If no error, proceed to insert into the database
        $sql = "INSERT INTO `searcheddata` (`searchedChassisNumber`, `dt`) VALUES ('$searchedChassisNumber', current_timestamp());";
        $result = mysqli_query($conn, $sql);
    }
}




function decodeChassis($chassisNumber) {
    // Extract the manufacturer code (assuming it's the first three characters)
    $manufacturerCode = strtoupper(substr($chassisNumber, 0, 3));

    switch ($manufacturerCode) {
        case 'MAT': // Tata Motors
            decodeTataMotors($chassisNumber);
            break;
        case 'MB1': // Ashok Leyland
            decodeAshokLeyland($chassisNumber);
            break;
        case 'MC1': // Force Motors
            decodeForceMotors($chassisNumber);
            break;
        case 'MAJ': // Ford Motors
            decodeFordMotors($chassisNumber);
            break;       
        case 'MBK': // MAN TRUCKS
            decodeManTrucks($chassisNumber);
            break;  
        case 'MBX': // PIAGGIO
            decodePiaggio($chassisNumber);
            break;  
        case 'MCG': // ATUL AUTO
            decodeAtulAuto($chassisNumber);
            break;  
        case 'WAU': // AUDI
            decodeAudi($chassisNumber);
            break; 
        case 'MD2': // BAJAJ
            decodeBajaj($chassisNumber);
            break; 
        case 'MBN': // MAHINDRA FE
            decodeMahindraTractor($chassisNumber);
            break; 
        case 'T05': // ESCORTS FE
            decodeEscortsFE($chassisNumber);
            break; 
        case 'MA3': // MARUTI SUZUKI
            decodeMarutiSuzuki($chassisNumber);
            break; 
        case 'MBH': // MARUTI SUZUKI
            decodeMarutiSuzukiN($chassisNumber);
            break;
        case 'MA1': // MAHINDRA
            decodeMahindra($chassisNumber);
            break;
        case 'MCD': // MAHINDRA 2W
            decodeMahindra2W($chassisNumber);
            break;
        case 'MAL': // HYUNDAI
            decodeHyundai($chassisNumber);
            break;
        case 'MAK': // HONDA
            decodeHonda($chassisNumber);
            break;
        case 'MEE': // RENAULT
            decodeRenault($chassisNumber);
            break;
        case 'ARG': // AJAX FIORI
            decodeAjaxFiori($chassisNumber);
            break;  
        case 'MBY': // AMW
            decodeAMW($chassisNumber);
            break;    
        case 'MEC': // BHARAT BENZ
            decodeBharatBenz($chassisNumber);
            break;  
        case 'WBA': // BMW
            decodeBMW($chassisNumber);
            break;
        case 'MC2': // EICHER MOTORS
            decodeEicherMotors($chassisNumber);
            break;
        case 'ME3': // ENFIELD
            decodeEnfield($chassisNumber);
            break;
        case 'MBL': // HERO
            decodeHero($chassisNumber);
            break;
        case 'ME4': // HONDA 2W
            decodeHonda2W($chassisNumber);
            break;
        case 'MER': // HYOSUNG
            decodeHyosung($chassisNumber);
            break;
        case 'NHN': // NEW HOLLAND TRACTOR
            decodeNewHolland($chassisNumber);
            break;
        case 'MDH': // NISSAN MOTORS
            decodeNissanMotors($chassisNumber);
            break;
        case 'TMB': // SKODA
            decodeSkoda($chassisNumber);
            break;
        case 'MD6': // TVS 2W
            decodeTVS2W($chassisNumber);
            break;
        case 'WVW': // VOLKSWAGEN
            decodeVolkswagen($chassisNumber);
            break;
        case 'ME1': // YAMAHA MOTORCYCLES
            decodeYamaha($chassisNumber);
            break;
        case 'MEA': // MASSEY FERGUSON (TAFE)
            decodeMassey($chassisNumber);
            break;
        case 'MZB': // KIA
            decodeKia($chassisNumber);
            break;
        case 'MCA': // JEEP
            decodeJeep($chassisNumber);
            break;
        case 'MZ7': // MG MOTORS
            decodeMg($chassisNumber);
            break;


        // Add more cases for other manufacturers
        case 'XYZ': // Another Manufacturer
            decodeAnotherManufacturer($chassisNumber);
            break;
        // Add more cases for other manufacturers
        default:
            $_SESSION['chassisResult'] = [
                'error' => "Unknown Manufacturer. Unable to decode chassis number."
            ];
            break;
    }
}




function decodeMg($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MZ7
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MZ7') {
        $manufacturer = "MG MOTORS";

        // Extract the 9th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[8]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            '1' => 2018, '2' => 2019,
            '3' => 2020, '4' => 2021, '5' => 2022, '6' => 2023, '7' => 2024,
            '8' => 2025, '9' => 2026
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeJeep($chassisNumber) {
    // Ensure the chassis number is exactly 19 characters and begins with MCA
    if (strlen($chassisNumber) === 19 && strtoupper(substr($chassisNumber, 0, 3)) === 'MCA') {
        $manufacturer = "JEEP";

        // Extract the 18th and 19th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[18]);
        $manufacturingMonthCode = strtoupper($chassisNumber[17]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                '1' => 'JANUARY', '2' => 'FEBRUARY', '3' => 'MARCH', '4' => 'APRIL',
                '5' => 'MAY', '6' => 'JUNE', '7' => 'JULY', '8' => 'AUGUST',
                '9' => 'SEPTEMBER', 'A' => 'OCTOBER', 'B' => 'NOVEMBER', 'C' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeKia($chassisNumber) {
    // Ensure the chassis number is exactly 18 characters and begins with MZB
    if (strlen($chassisNumber) === 18 && strtoupper(substr($chassisNumber, 0, 3)) === 'MZB') {
        $manufacturer = "KIA";

        // Extract the 10th and 18th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[17]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeMassey($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MEA
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MEA') {
        $manufacturer = "MASSEY FERGUSON (TAFE)";

        // Extract the 9th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[8]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeYamaha($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with ME1
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'ME1') {
        $manufacturer = "YAMAHA MOTORCYCLES";

        // Extract the 9th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[8]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                '1' => 'JANUARY', '2' => 'FEBRUARY', '3' => 'MARCH', '4' => 'APRIL',
                '5' => 'MAY', '6' => 'JUNE', '7' => 'JULY', '8' => 'AUGUST',
                '9' => 'SEPTEMBER', 'A' => 'OCTOBER', 'B' => 'NOVEMBER', 'C' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeVolkswagen($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with WVW
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'WVW') {
        $manufacturer = "VOLKSWAGEN";

        // Extract the 4th and 5-6th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper(substr($chassisNumber, 4, 2));
        $manufacturingMonthCode = strtoupper($chassisNumber[3]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            '11' => 2011, '12' => 2012, '13' => 2013, '14' => 2014,
            '15' => 2015, '16' => 2016, '17' => 2017, '18' => 2018, '19' => 2019,
            '20' => 2020, '21' => 2021, '22' => 2022, '23' => 2023, '24' => 2024,
            '25' => 2025, '26' => 2026, '27' => 2027, '28' => 2028, '29' => 2029, '30' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}





function decodeTVS2W($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MD6
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MD6') {
        $manufacturer = "TVS 2W";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'K' => 'SEPTEMBER', 'L' => 'OCTOBER', 'N' => 'NOVEMBER', 'P' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeSkoda($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with TMB
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'TMB') {
        $manufacturer = "SKODA";

        // Extract the 6th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[5]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeNissanMotors($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MDH
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MDH') {
        $manufacturer = "NISSAN MOTORS";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                '1' => 'JANUARY', '2' => 'FEBRUARY', '3' => 'MARCH', '4' => 'APRIL',
                '5' => 'MAY', '6' => 'JUNE', '7' => 'JULY', '8' => 'AUGUST',
                '9' => 'SEPTEMBER', 'A' => 'OCTOBER', 'B' => 'NOVEMBER', 'C' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeNewHolland($chassisNumber) {
    // Ensure the chassis number is exactly 16 characters and begins with NHN
    if (strlen($chassisNumber) === 16 && strtoupper(substr($chassisNumber, 0, 3)) === 'NHN') {
        $manufacturer = "NEW HOLLAND TRACTOR";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeHyosung($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MER
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MER') {
        $manufacturer = "HYOSUNG";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            '1' => 2011, '2' => 2012, '3' => 2013, '4' => 2014,
            '5' => 2015, '6' => 2016, '7' => 2017, '8' => 2018, '9' => 2019,
            'A' => 2020, 'B' => 2021, 'C' => 2022, 'D' => 2023, 'E' => 2024,
            'F' => 2025, 'G' => 2026, 'H' => 2027, 'J' => 2028, 'K' => 2029, 'L' => 2030, 'M' => 2031, 'N' => 2032, 'P' => 2033, 'R' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeHonda2W($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with ME4
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'ME4') {
        $manufacturer = "HONDA 2W";

        // Extract the 9th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[8]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}





function decodeHero($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MBL
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MBL') {
        $manufacturer = "HERO";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeEnfield($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with ME3
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'ME3') {
        $manufacturer = "ENFIELD";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'K' => 'SEPTEMBER', 'L' => 'OCTOBER', 'M' => 'NOVEMBER', 'N' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}





function decodeEicherMotors($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MC2
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MC2') {
        $manufacturer = "EICHER MOTORS";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'A' => 2010,'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeBMW($chassisNumber) {
    // Ensure the chassis number is exactly 19 characters and begins with WBA
    if (strlen($chassisNumber) === 19 && strtoupper(substr($chassisNumber, 0, 3)) === 'WBA') {
        $manufacturer = "BMW";

        // Extract the 18th and 19th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[18]);
        $manufacturingMonthCode = strtoupper($chassisNumber[17]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'U' => 2027, 'V' => 2028, 'W' => 2029, 'X' => 2030, 'Y' => 2031
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeBharatBenz($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MEC
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MEC') {
        $manufacturer = "BHARAT BENZ";

        // Extract the 9th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[8]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeAMW($chassisNumber) {
    // Ensure the chassis number is exactly 18 characters and begins with MBY
    if (strlen($chassisNumber) === 18 && strtoupper(substr($chassisNumber, 0, 3)) === 'MBY') {
        $manufacturer = "AMW";

        // Extract the 9th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeAjaxFiori($chassisNumber) {
    // Ensure the chassis number is exactly 15 characters and begins with ARG
    if (strlen($chassisNumber) === 15 && strtoupper(substr($chassisNumber, 0, 3)) === 'ARG') {
        $manufacturer = "AJAX FIORI";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper(substr($chassisNumber, 5, 4));
        $manufacturingMonthCode = strtoupper(substr($chassisNumber, 9, 2));

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            '2011' => 2011, '2012' => 2012, '2013' => 2013, '2014' => 2014,
            '2015' => 2015, '2016' => 2016, '2017' => 2017, '2018' => 2018, '2019' => 2019,
            '2020' => 2020, '2021' => 2021, '2022' => 2022, '2023' => 2023, '2024' => 2024,
            '2025' => 2025, '2026' => 2026, '2027' => 2027, '2028' => 2028, '2029' => 2029, '2030' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                '01' => 'JANUARY', '02' => 'FEBRUARY', '03' => 'MARCH', '04' => 'APRIL',
                '05' => 'MAY', '06' => 'JUNE', '07' => 'JULY', '08' => 'AUGUST',
                '09' => 'SEPTEMBER', '10' => 'OCTOBER', '11' => 'NOVEMBER', '12' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}



function decodeRenault($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MEE
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MEE') {
        $manufacturer = "RENAULT";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                '1' => 'JANUARY', '2' => 'FEBRUARY', '3' => 'MARCH', '4' => 'APRIL',
                '5' => 'MAY', '6' => 'JUNE', '7' => 'JULY', '8' => 'AUGUST',
                '9' => 'SEPTEMBER', 'A' => 'OCTOBER', 'B' => 'NOVEMBER', 'C' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeHonda($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MAK
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MAK') {
        $manufacturer = "HONDA";

        // Extract the 9th and 10th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[8]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeHyundai($chassisNumber) {
    // Ensure the chassis number is exactly 18 characters and begins with MAL
    if (strlen($chassisNumber) === 18 && strtoupper(substr($chassisNumber, 0, 3)) === 'MAL') {
        $manufacturer = "HYUNDAI";

        // Extract the 10th and 18th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[17]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}




function decodeMahindra2W($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MCD
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MCD') {
        $manufacturer = "MAHINDRA 2W";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}



function decodeMahindra($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MA1
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MA1') {
        $manufacturer = "MAHINDRA";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}



function decodeMarutiSuzukiN($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MBH
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MBH') {
        $manufacturer = "Maruti Suzuki";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}

function decodeMarutiSuzuki($chassisNumber) {
    // Ensure the chassis number is either 17 or 19 characters and begins with MA3
    if ((strlen($chassisNumber) === 17 || strlen($chassisNumber) === 19) && strtoupper(substr($chassisNumber, 0, 3)) === 'MA3') {
        $manufacturer = "Maruti";

        // Extract the 10th and 11th characters (if input is 17 characters) or 18th and 19th characters (if input is 19 characters) for decoding (converted to uppercase)
        $manufacturingMonthCode = strtoupper((strlen($chassisNumber) === 17) ? $chassisNumber[10] : $chassisNumber[17]);
        $manufacturingYearCode = strtoupper((strlen($chassisNumber) === 17) ? $chassisNumber[9] : $chassisNumber[18]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}

function decodeTataMotors($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MAT
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MAT') {
        $manufacturer = "Tata Motors";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'A' => 2010, 'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
                'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
                'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'N' => 'NOVEMBER', 'P' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for Tata Motors. Please enter a valid chassis number."
        ];
    }
}

function decodeAshokLeyland($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MB1
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MB1') {
        $manufacturer = "ASHOK LEYLAND";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year for ASHOK LEYLAND
        $manufacturingYears = [
            'B' => 2011,
            'C' => 2012,
            'D' => 2013,
            'E' => 2014,
            'F' => 2015,
            'G' => 2016,
            'H' => 2017,
            'J' => 2018,
            'K' => 2019,
            'L' => 2020,
            'M' => 2021,
            'N' => 2022,
            'P' => 2023,
            'R' => 2024,
            'S' => 2025,
            'T' => 2026,
            'V' => 2027,
            'W' => 2028
            // Add more years as needed
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month for ASHOK LEYLAND
            $manufacturingMonthsCondition1 = [
                'A' => 'JANUARY', 'Y' => 'FEBRUARY', 'X' => 'MARCH', 'W' => 'APRIL',
                'V' => 'MAY', 'T' => 'JUNE', 'S' => 'JULY', 'R' => 'AUGUST',
                'P' => 'SEPTEMBER', 'N' => 'OCTOBER', 'M' => 'NOVEMBER', 'L' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition2 = [
                'B' => 'JANUARY', 'A' => 'FEBRUARY', 'Y' => 'MARCH', 'X' => 'APRIL',
                'W' => 'MAY', 'V' => 'JUNE', 'T' => 'JULY', 'S' => 'AUGUST',
                'R' => 'SEPTEMBER', 'P' => 'OCTOBER', 'N' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition3 = [
                'C' => 'JANUARY', 'B' => 'FEBRUARY', 'A' => 'MARCH', 'Y' => 'APRIL', 'X' => 'MAY', 'W' => 'JUNE', 'V' => 'JULY', 'T' => 'AUGUST', 'S' => 'SEPTEMBER', 'R' => 'OCTOBER', 'P' => 'NOVEMBER', 'N' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition4 = [
                'D' => 'JANUARY', 'C' => 'FEBRUARY', 'B' => 'MARCH', 'A' => 'APRIL', 'Y' => 'MAY', 'X' => 'JUNE', 'W' => 'JULY', 'V' => 'AUGUST', 'T' => 'SEPTEMBER', 'S' => 'OCTOBER', 'R' => 'NOVEMBER', 'P' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition5 = [
                'E' => 'JANUARY', 'D' => 'FEBRUARY', 'C' => 'MARCH', 'B' => 'APRIL', 'A' => 'MAY', 'Y' => 'JUNE', 'X' => 'JULY', 'W' => 'AUGUST', 'V' => 'SEPTEMBER', 'T' => 'OCTOBER', 'S' => 'NOVEMBER', 'G' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition6 = [
                'F' => 'JANUARY', 'E' => 'FEBRUARY', 'D' => 'MARCH', 'C' => 'APRIL', 'B' => 'MAY', 'A' => 'JUNE', 'Y' => 'JULY', 'X' => 'AUGUST', 'W' => 'SEPTEMBER', 'V' => 'OCTOBER', 'T' => 'NOVEMBER', 'H' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition7 = [
                'G' => 'JANUARY', 'F' => 'FEBRUARY', 'E' => 'MARCH', 'D' => 'APRIL', 'C' => 'MAY', 'B' => 'JUNE', 'A' => 'JULY', 'Y' => 'AUGUST', 'X' => 'SEPTEMBER', 'W' => 'OCTOBER', 'V' => 'NOVEMBER', 'J' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition8 = [
                'H' => 'JANUARY', 'G' => 'FEBRUARY', 'F' => 'MARCH', 'E' => 'APRIL', 'D' => 'MAY', 'C' => 'JUNE', 'B' => 'JULY', 'A' => 'AUGUST', 'Y' => 'SEPTEMBER', 'X' => 'OCTOBER', 'W' => 'NOVEMBER', 'K' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition9 = [
                'J' => 'JANUARY', 'H' => 'FEBRUARY', 'G' => 'MARCH', 'F' => 'APRIL', 'E' => 'MAY', 'D' => 'JUNE', 'C' => 'JULY', 'B' => 'AUGUST', 'A' => 'SEPTEMBER', 'Y' => 'OCTOBER', 'X' => 'NOVEMBER', 'L' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition10 = [
                'K' => 'JANUARY', 'J' => 'FEBRUARY', 'H' => 'MARCH', 'G' => 'APRIL', 'F' => 'MAY', 'E' => 'JUNE', 'D' => 'JULY', 'C' => 'AUGUST', 'B' => 'SEPTEMBER', 'A' => 'OCTOBER', 'Y' => 'NOVEMBER', 'M' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition11 = [
                'L' => 'JANUARY', 'K' => 'FEBRUARY', 'J' => 'MARCH', 'H' => 'APRIL', 'G' => 'MAY', 'F' => 'JUNE', 'E' => 'JULY', 'D' => 'AUGUST', 'C' => 'SEPTEMBER', 'B' => 'OCTOBER', 'A' => 'NOVEMBER', 'N' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition12 = [
                'M' => 'JANUARY', 'L' => 'FEBRUARY', 'K' => 'MARCH', 'J' => 'APRIL', 'H' => 'MAY', 'G' => 'JUNE', 'F' => 'JULY', 'E' => 'AUGUST', 'D' => 'SEPTEMBER', 'C' => 'OCTOBER', 'B' => 'NOVEMBER', 'P' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition13 = [
                'N' => 'JANUARY', 'M' => 'FEBRUARY', 'L' => 'MARCH', 'K' => 'APRIL', 'J' => 'MAY', 'H' => 'JUNE', 'G' => 'JULY', 'F' => 'AUGUST', 'E' => 'SEPTEMBER', 'D' => 'OCTOBER', 'C' => 'NOVEMBER', 'R' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition14 = [
                'P' => 'JANUARY', 'N' => 'FEBRUARY', 'M' => 'MARCH', 'L' => 'APRIL', 'K' => 'MAY', 'J' => 'JUNE', 'H' => 'JULY', 'G' => 'AUGUST', 'F' => 'SEPTEMBER', 'E' => 'OCTOBER', 'D' => 'NOVEMBER', 'S' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition15 = [
                'R' => 'JANUARY', 'P' => 'FEBRUARY', 'N' => 'MARCH', 'M' => 'APRIL', 'L' => 'MAY', 'K' => 'JUNE', 'J' => 'JULY', 'H' => 'AUGUST', 'G' => 'SEPTEMBER', 'F' => 'OCTOBER', 'E' => 'NOVEMBER', 'T' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition16 = [
                'S' => 'JANUARY', 'R' => 'FEBRUARY', 'P' => 'MARCH', 'N' => 'APRIL', 'M' => 'MAY', 'L' => 'JUNE', 'K' => 'JULY', 'J' => 'AUGUST', 'H' => 'SEPTEMBER', 'G' => 'OCTOBER', 'F' => 'NOVEMBER', 'V' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition17 = [
                'T' => 'JANUARY', 'S' => 'FEBRUARY', 'R' => 'MARCH', 'P' => 'APRIL', 'N' => 'MAY', 'M' => 'JUNE', 'L' => 'JULY', 'K' => 'AUGUST', 'J' => 'SEPTEMBER', 'H' => 'OCTOBER', 'G' => 'NOVEMBER', 'W' => 'DECEMBER'
            ];

            $manufacturingMonthsCondition18 = [
                'V' => 'JANUARY', 'T' => 'FEBRUARY', 'S' => 'MARCH', 'R' => 'APRIL', 'P' => 'MAY', 'N' => 'JUNE', 'M' => 'JULY', 'L' => 'AUGUST', 'K' => 'SEPTEMBER', 'J' => 'OCTOBER', 'H' => 'NOVEMBER', 'X' => 'DECEMBER'
            ];

            if (isset($manufacturingMonthsCondition1[$manufacturingMonthCode]) && $manufacturingYearCode === 'B') {
                $manufacturingMonth = $manufacturingMonthsCondition1[$manufacturingMonthCode];
            } elseif (isset($manufacturingMonthsCondition2[$manufacturingMonthCode]) && $manufacturingYearCode === 'C') {
                $manufacturingMonth = $manufacturingMonthsCondition2[$manufacturingMonthCode];
            } elseif (isset($manufacturingMonthsCondition3[$manufacturingMonthCode]) && $manufacturingYearCode === 'D') {
                $manufacturingMonth = $manufacturingMonthsCondition3[$manufacturingMonthCode];
            } elseif (isset($manufacturingMonthsCondition4[$manufacturingMonthCode]) && $manufacturingYearCode === 'E') {
                $manufacturingMonth = $manufacturingMonthsCondition4[$manufacturingMonthCode];
            } elseif (isset($manufacturingMonthsCondition5[$manufacturingMonthCode]) && $manufacturingYearCode === 'F') {
                $manufacturingMonth = $manufacturingMonthsCondition5[$manufacturingMonthCode];
            } elseif (isset($manufacturingMonthsCondition6[$manufacturingMonthCode]) && $manufacturingYearCode === 'G') {
                $manufacturingMonth = $manufacturingMonthsCondition6[$manufacturingMonthCode];   
            } elseif (isset($manufacturingMonthsCondition7[$manufacturingMonthCode]) && $manufacturingYearCode === 'H') {
                $manufacturingMonth = $manufacturingMonthsCondition7[$manufacturingMonthCode];    
            } elseif (isset($manufacturingMonthsCondition8[$manufacturingMonthCode]) && $manufacturingYearCode === 'J') {
                $manufacturingMonth = $manufacturingMonthsCondition8[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition9[$manufacturingMonthCode]) && $manufacturingYearCode === 'K') {
                $manufacturingMonth = $manufacturingMonthsCondition9[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition10[$manufacturingMonthCode]) && $manufacturingYearCode === 'L') {
                $manufacturingMonth = $manufacturingMonthsCondition10[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition11[$manufacturingMonthCode]) && $manufacturingYearCode === 'M') {
                $manufacturingMonth = $manufacturingMonthsCondition11[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition12[$manufacturingMonthCode]) && $manufacturingYearCode === 'N') {
                $manufacturingMonth = $manufacturingMonthsCondition12[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition13[$manufacturingMonthCode]) && $manufacturingYearCode === 'P') {
                $manufacturingMonth = $manufacturingMonthsCondition13[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition14[$manufacturingMonthCode]) && $manufacturingYearCode === 'R') {
                $manufacturingMonth = $manufacturingMonthsCondition14[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition15[$manufacturingMonthCode]) && $manufacturingYearCode === 'S') {
                $manufacturingMonth = $manufacturingMonthsCondition15[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition16[$manufacturingMonthCode]) && $manufacturingYearCode === 'T') {
                $manufacturingMonth = $manufacturingMonthsCondition16[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition17[$manufacturingMonthCode]) && $manufacturingYearCode === 'V') {
                $manufacturingMonth = $manufacturingMonthsCondition17[$manufacturingMonthCode]; 
            } elseif (isset($manufacturingMonthsCondition18[$manufacturingMonthCode]) && $manufacturingYearCode === 'W') {
                $manufacturingMonth = $manufacturingMonthsCondition18[$manufacturingMonthCode]; 
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid for ASHOK LEYLAND."
                ];
                return;
            }

            // Store results in the session
            $_SESSION['chassisResult'] = [
                'manufacturer' => $manufacturer,
                'manufacturingMonth' => $manufacturingMonth,
                'manufacturingYear' => $manufacturingYear
            ];
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid for ASHOK LEYLAND."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for ASHOK LEYLAND. Please enter a valid chassis number."
        ];
    }
}


function decodeForceMotors($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MC1
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MC1') {
        $manufacturer = "FORCE MOTORS";

        // Extract the 10th and 7th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[6]);

        // Validating and decoding the manufacturing year for FORCE MOTORS
        $manufacturingYearsCondition1 = [
            'B' => 2010, 'C' => 2011, 'D' => 2012, 'E' => 2013, 'F' => 2014, 'G' => 2015, 'H' => 2016, 'J' => 2017, 'K' => 2018, 'L' => 2019, 'M' => 2020, 'N' => 2021, 'P' => 2022, 'R' => 2023, 'S' => 2024, 'T' => 2025, 'V' => 2026, 'W' => 2027, 'X' => 2028, 'Y' => 2029
        ];

        $manufacturingYearsCondition2 = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014, 'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019, 'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024, 'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030
        ];

        if ($manufacturingMonthCode === 'G' || $manufacturingMonthCode === 'H' || $manufacturingMonthCode === 'J' ||
            $manufacturingMonthCode === 'K' || $manufacturingMonthCode === 'L' || $manufacturingMonthCode === 'M') {
            if (isset($manufacturingYearsCondition1[$manufacturingYearCode])) {
                $manufacturingYear = $manufacturingYearsCondition1[$manufacturingYearCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing year code is not valid for FORCE MOTORS."
                ];
                return;
            }
        } elseif ($manufacturingMonthCode === 'A' || $manufacturingMonthCode === 'B' || $manufacturingMonthCode === 'C' ||
                  $manufacturingMonthCode === 'D' || $manufacturingMonthCode === 'E' || $manufacturingMonthCode === 'F') {
            if (isset($manufacturingYearsCondition2[$manufacturingYearCode])) {
                $manufacturingYear = $manufacturingYearsCondition2[$manufacturingYearCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing year code is not valid for FORCE MOTORS."
                ];
                return;
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing month code is not valid for FORCE MOTORS."
            ];
            return;
        }

        // Validating and decoding the manufacturing month for FORCE MOTORS
        $manufacturingMonthsCondition1 = [
            'G' => 'JULY', 'H' => 'AUGUST', 'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
        ];

        $manufacturingMonthsCondition2 = [
            'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL', 'E' => 'MAY', 'F' => 'JUNE'
        ];

        if (($manufacturingMonthCode === 'G' || $manufacturingMonthCode === 'H' || $manufacturingMonthCode === 'J' ||
             $manufacturingMonthCode === 'K' || $manufacturingMonthCode === 'L' || $manufacturingMonthCode === 'M') &&
             isset($manufacturingMonthsCondition1[$manufacturingMonthCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition1[$manufacturingMonthCode];
        } elseif (($manufacturingMonthCode === 'A' || $manufacturingMonthCode === 'B' || $manufacturingMonthCode === 'C' ||
                   $manufacturingMonthCode === 'D' || $manufacturingMonthCode === 'E' || $manufacturingMonthCode === 'F') &&
                   isset($manufacturingMonthsCondition2[$manufacturingMonthCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition2[$manufacturingMonthCode];
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing month code is not valid for FORCE MOTORS."
            ];
            return;
        }

        // Store results in the session
        $_SESSION['chassisResult'] = [
            'manufacturer' => $manufacturer,
            'manufacturingMonth' => $manufacturingMonth,
            'manufacturingYear' => $manufacturingYear
        ];
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for FORCE MOTORS. Please enter a valid chassis number."
        ];
    }
}

function decodeFordMotors($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MAJ
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MAJ') {
        $manufacturer = "FORD MOTORS";

        // Extract the 11th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[10]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year for FORD MOTORS
        $manufacturingYearsCondition1 = [
            'C' => 2012, 'G' => 2016, 'L' => 2020, 'R' => 2024
        ];

        $manufacturingYearsCondition2 = [
            'D' => 2013, 'H' => 2017, 'M' => 2021, 'S' => 2025
        ];

        $manufacturingYearsCondition3 = [
            'E' => 2014, 'J' => 2018, 'L' => 2022, 'R' => 2026
        ];

        $manufacturingYearsCondition4 = [
            'B' => 2011, 'F' => 2015, 'H' => 2019, 'M' => 2023, 'S' => 2027
        ];

        if (isset($manufacturingYearsCondition1[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYearsCondition1[$manufacturingYearCode];

            // Validating and decoding the manufacturing month for FORD MOTORS
            $manufacturingMonthsCondition1 = [
                'B' => 'JANUARY', 'R' => 'FEBRUARY', 'A' => 'MARCH', 'G' => 'APRIL',
                'C' => 'MAY', 'K' => 'JUNE', 'D' => 'JULY', 'E' => 'AUGUST',
                'L' => 'SEPTEMBER', 'Y' => 'OCTOBER', 'S' => 'NOVEMBER', 'T' => 'DECEMBER'
            ];

            if (isset($manufacturingMonthsCondition1[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonthsCondition1[$manufacturingMonthCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid for FORD MOTORS."
                ];
                return;
            }
        } elseif (isset($manufacturingYearsCondition2[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYearsCondition2[$manufacturingYearCode];

            // Validating and decoding the manufacturing month for FORD MOTORS
            $manufacturingMonthsCondition2 = [
                'J' => 'JANUARY', 'U' => 'FEBRUARY', 'M' => 'MARCH', 'P' => 'APRIL',
                'B' => 'MAY', 'R' => 'JUNE', 'A' => 'JULY', 'G' => 'AUGUST',
                'C' => 'SEPTEMBER', 'K' => 'OCTOBER', 'D' => 'NOVEMBER', 'E' => 'DECEMBER'
            ];

            if (isset($manufacturingMonthsCondition2[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonthsCondition2[$manufacturingMonthCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid for FORD MOTORS."
                ];
                return;
            }
        } elseif (isset($manufacturingYearsCondition3[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYearsCondition3[$manufacturingYearCode];

            // Validating and decoding the manufacturing month for FORD MOTORS
            $manufacturingMonthsCondition3 = [
                'L' => 'JANUARY', 'Y' => 'FEBRUARY', 'S' => 'MARCH', 'T' => 'APRIL',
                'J' => 'MAY', 'U' => 'JUNE', 'M' => 'JULY', 'P' => 'AUGUST',
                'B' => 'SEPTEMBER', 'R' => 'OCTOBER', 'A' => 'NOVEMBER', 'G' => 'DECEMBER'
            ];

            if (isset($manufacturingMonthsCondition3[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonthsCondition3[$manufacturingMonthCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid for FORD MOTORS."
                ];
                return;
            }    
        } elseif (isset($manufacturingYearsCondition4[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYearsCondition4[$manufacturingYearCode];

            // Validating and decoding the manufacturing month for FORD MOTORS
            $manufacturingMonthsCondition4 = [
                'C' => 'JANUARY', 'K' => 'FEBRUARY', 'D' => 'MARCH', 'E' => 'APRIL',
                'L' => 'MAY', 'Y' => 'JUNE', 'S' => 'JULY', 'T' => 'AUGUST',
                'J' => 'SEPTEMBER', 'U' => 'OCTOBER', 'M' => 'NOVEMBER', 'P' => 'DECEMBER'
            ];

            if (isset($manufacturingMonthsCondition4[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonthsCondition4[$manufacturingMonthCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid for FORD MOTORS."
                ];
                return;
            }    
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid for FORD MOTORS."
            ];
            return;
        }

        // Store results in the session
        $_SESSION['chassisResult'] = [
            'manufacturer' => $manufacturer,
            'manufacturingMonth' => $manufacturingMonth,
            'manufacturingYear' => $manufacturingYear
        ];
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for FORD MOTORS. Please enter a valid chassis number."
        ];
    }
}

function decodeManTrucks($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MBK
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MBK') {
        $manufacturer = "MAN TRUCKS";

        // Extract the 10th and 7th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[6]);

        // Validating and decoding the manufacturing year for MAN TRUCKS
        $manufacturingYearsCondition1 = [
            'B' => 2010, 'C' => 2011, 'D' => 2012, 'E' => 2013, 'F' => 2014, 'G' => 2015, 'H' => 2016, 'J' => 2017, 'K' => 2018, 'L' => 2019, 'M' => 2020, 'N' => 2021, 'P' => 2022, 'R' => 2023, 'S' => 2024, 'T' => 2025, 'U' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, 'Z' => 2031, '1' => 2032
        ];

        $manufacturingYearsCondition2 = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014, 'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019, 'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024, 'S' => 2025, 'T' => 2026, 'U' => 2027, 'V' => 2028, 'W' => 2029, 'X' => 2030, 'Y' => 2031, 'Z' => 2032, '1' => 2033
        ];

        if ($manufacturingMonthCode === 'G' || $manufacturingMonthCode === 'H' || $manufacturingMonthCode === 'J' ||
            $manufacturingMonthCode === 'K' || $manufacturingMonthCode === 'L' || $manufacturingMonthCode === 'M') {
            if (isset($manufacturingYearsCondition1[$manufacturingYearCode])) {
                $manufacturingYear = $manufacturingYearsCondition1[$manufacturingYearCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing year code is not valid for MAN TRUCKS."
                ];
                return;
            }
        } elseif ($manufacturingMonthCode === 'A' || $manufacturingMonthCode === 'B' || $manufacturingMonthCode === 'C' ||
                  $manufacturingMonthCode === 'D' || $manufacturingMonthCode === 'E' || $manufacturingMonthCode === 'F') {
            if (isset($manufacturingYearsCondition2[$manufacturingYearCode])) {
                $manufacturingYear = $manufacturingYearsCondition2[$manufacturingYearCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing year code is not valid for MAN TRUCKS."
                ];
                return;
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing month code is not valid for MAN TRUCKS."
            ];
            return;
        }

        // Validating and decoding the manufacturing month for MAN TRUCKS
        $manufacturingMonthsCondition1 = [
            'G' => 'JULY', 'H' => 'AUGUST', 'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
        ];

        $manufacturingMonthsCondition2 = [
            'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL', 'E' => 'MAY', 'F' => 'JUNE'
        ];

        if (($manufacturingMonthCode === 'G' || $manufacturingMonthCode === 'H' || $manufacturingMonthCode === 'J' ||
             $manufacturingMonthCode === 'K' || $manufacturingMonthCode === 'L' || $manufacturingMonthCode === 'M') &&
             isset($manufacturingMonthsCondition1[$manufacturingMonthCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition1[$manufacturingMonthCode];
        } elseif (($manufacturingMonthCode === 'A' || $manufacturingMonthCode === 'B' || $manufacturingMonthCode === 'C' ||
                   $manufacturingMonthCode === 'D' || $manufacturingMonthCode === 'E' || $manufacturingMonthCode === 'F') &&
                   isset($manufacturingMonthsCondition2[$manufacturingMonthCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition2[$manufacturingMonthCode];
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing month code is not valid for MAN TRUCKS."
            ];
            return;
        }

        // Store results in the session
        $_SESSION['chassisResult'] = [
            'manufacturer' => $manufacturer,
            'manufacturingMonth' => $manufacturingMonth,
            'manufacturingYear' => $manufacturingYear
        ];
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for MAN TRUCKS. Please enter a valid chassis number."
        ];
    }
}

function decodePiaggio($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MBX
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MBX') {
        $manufacturer = "PIAGGIO";

        // Extract the 10th and 11th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year for PIAGGIO
        $manufacturingYearsCondition1 = [
            'P' => 2012, 'R' => 2013, 'S' => 2014, 'T' => 2015, 'U' => 2016, 'V' => 2017, 'W' => 2018, 'X' => 2019, 'Y' => 2020, 'Z' => 2021, '1' => 2022, '2' => 2023, '3' => 2024, '4' => 2025, '5' => 2026, '6' => 2027, '7' => 2028, '8' => 2029
        ];

        $manufacturingYearsCondition2 = [
            'P' => 2013, 'R' => 2014, 'S' => 2015, 'T' => 2016, 'U' => 2017, 'V' => 2018, 'W' => 2019, 'X' => 2020, 'Y' => 2021, 'Z' => 2022, '1' => 2023, '2' => 2024, '3' => 2025, '4' => 2026, '5' => 2027, '6' => 2028, '7' => 2029, '8' => 2030
        ];

        if ($manufacturingMonthCode === 'D' || $manufacturingMonthCode === 'E' || $manufacturingMonthCode === 'F' ||  $manufacturingMonthCode === 'G' || $manufacturingMonthCode === 'H' || $manufacturingMonthCode === 'J' || $manufacturingMonthCode === 'K' || $manufacturingMonthCode === 'L' || $manufacturingMonthCode === 'M') {
            if (isset($manufacturingYearsCondition1[$manufacturingYearCode])) {
                $manufacturingYear = $manufacturingYearsCondition1[$manufacturingYearCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing year code is not valid for PIAGGIO."
                ];
                return;
            }
        } elseif ($manufacturingMonthCode === 'A' || $manufacturingMonthCode === 'B' || $manufacturingMonthCode === 'C') {
            if (isset($manufacturingYearsCondition2[$manufacturingYearCode])) {
                $manufacturingYear = $manufacturingYearsCondition2[$manufacturingYearCode];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing year code is not valid for PIAGGIO."
                ];
                return;
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing month code is not valid for PIAGGIO."
            ];
            return;
        }

        // Validating and decoding the manufacturing month for PIAGGIO
        $manufacturingMonthsCondition1 = [
            'D' => 'APRIL', 'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST', 'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
        ];

        $manufacturingMonthsCondition2 = [
            'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH'
        ];

        if (($manufacturingMonthCode === 'D' || $manufacturingMonthCode === 'E' || $manufacturingMonthCode === 'F' || $manufacturingMonthCode === 'G' || $manufacturingMonthCode === 'H' || $manufacturingMonthCode === 'J' ||
             $manufacturingMonthCode === 'K' || $manufacturingMonthCode === 'L' || $manufacturingMonthCode === 'M') &&
             isset($manufacturingMonthsCondition1[$manufacturingMonthCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition1[$manufacturingMonthCode];
        } elseif (($manufacturingMonthCode === 'A' || $manufacturingMonthCode === 'B' || $manufacturingMonthCode === 'C') &&
                   isset($manufacturingMonthsCondition2[$manufacturingMonthCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition2[$manufacturingMonthCode];
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing month code is not valid for PIAGGIO."
            ];
            return;
        }

        // Store results in the session
        $_SESSION['chassisResult'] = [
            'manufacturer' => $manufacturer,
            'manufacturingMonth' => $manufacturingMonth,
            'manufacturingYear' => $manufacturingYear
        ];
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for PIAGGIO. Please enter a valid chassis number."
        ];
    }
}

function decodeAtulAuto($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MCG
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MCG') {
        $manufacturer = "ATUL AUTO";

        // Extract the 10th, 11th, and 12th characters for decoding (converted to uppercase)
        $manufacturingMonthCode = strtoupper($chassisNumber[9]);
        $manufacturingYearCode = strtoupper(substr($chassisNumber, 10, 2));

        // Validating and decoding the manufacturing month for ATUL AUTO
        $manufacturingMonthsCondition = [
            'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
            'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
            'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
        ];

        // Validating and decoding the manufacturing year for ATUL AUTO
        $manufacturingYearsCondition = [
            '11' => 2011, '12' => 2012, '13' => 2013, '14' => 2014, '15' => 2015, '16' => 2016, '17' => 2017, '18' => 2018, '19' => 2019,'20' => 2020, '21' => 2021, '22' => 2022, '23' => 2023, '24' => 2024, '25' => 2025, '26' => 2026, '27' => 2027, '28' => 2028, '29' => 2029
        ];

        if (isset($manufacturingMonthsCondition[$manufacturingMonthCode]) && isset($manufacturingYearsCondition[$manufacturingYearCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition[$manufacturingMonthCode];
            $manufacturingYear = $manufacturingYearsCondition[$manufacturingYearCode];

            // Store results in the session
            $_SESSION['chassisResult'] = [
                'manufacturer' => $manufacturer,
                'manufacturingMonth' => $manufacturingMonth,
                'manufacturingYear' => $manufacturingYear
            ];
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Please enter a valid chassis number for ATUL AUTO."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for ATUL AUTO. Please enter a valid chassis number."
        ];
    }
}

function decodeAudi($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with WAU
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'WAU') {
        $manufacturer = "AUDI";

        // Extract the 5th and 6th characters for decoding (converted to uppercase)
        $manufacturingMonthCode = strtoupper($chassisNumber[4]);
        $manufacturingYearCode = strtoupper($chassisNumber[5]);

        // Validating and decoding the manufacturing month for AUDI
        $manufacturingMonthsCondition = [
            'A' => 'JANUARY', 'B' => 'FEBRUARY', 'C' => 'MARCH', 'D' => 'APRIL',
            'E' => 'MAY', 'F' => 'JUNE', 'G' => 'JULY', 'H' => 'AUGUST',
            'J' => 'SEPTEMBER', 'K' => 'OCTOBER', 'L' => 'NOVEMBER', 'M' => 'DECEMBER'
        ];

        // Validating and decoding the manufacturing year for AUDI
        $manufacturingYearsCondition = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014, 'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019, 'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024, 'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2033
        ];

        if (isset($manufacturingMonthsCondition[$manufacturingMonthCode]) && isset($manufacturingYearsCondition[$manufacturingYearCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition[$manufacturingMonthCode];
            $manufacturingYear = $manufacturingYearsCondition[$manufacturingYearCode];

            // Store results in the session
            $_SESSION['chassisResult'] = [
                'manufacturer' => $manufacturer,
                'manufacturingMonth' => $manufacturingMonth,
                'manufacturingYear' => $manufacturingYear
            ];
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Please enter a valid chassis number for AUDI."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for AUDI. Please enter a valid chassis number."
        ];
    }
}

function decodeBajaj($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MD2
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MD2') {
        $manufacturer = "BAJAJ";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);
        $manufacturingYearCode = strtoupper($chassisNumber[9]);

        // Validating and decoding the manufacturing month for BAJAJ
        $manufacturingMonthsCondition = [
            'K' => 'JANUARY', 'L' => 'FEBRUARY', 'M' => 'MARCH', 'A' => 'APRIL',
            'B' => 'MAY', 'C' => 'JUNE', 'D' => 'JULY', 'E' => 'AUGUST',
            'F' => 'SEPTEMBER', 'G' => 'OCTOBER', 'H' => 'NOVEMBER', 'J' => 'DECEMBER'
        ];

        // Validating and decoding the manufacturing year for BAJAJ
        $manufacturingYearsCondition = [
            'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014, 'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019, 'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024, 'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2033
        ];

        if (isset($manufacturingMonthsCondition[$manufacturingMonthCode]) && isset($manufacturingYearsCondition[$manufacturingYearCode])) {
            $manufacturingMonth = $manufacturingMonthsCondition[$manufacturingMonthCode];
            $manufacturingYear = $manufacturingYearsCondition[$manufacturingYearCode];

            // Store results in the session
            $_SESSION['chassisResult'] = [
                'manufacturer' => $manufacturer,
                'manufacturingMonth' => $manufacturingMonth,
                'manufacturingYear' => $manufacturingYear
            ];
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Please enter a valid chassis number for BAJAJ."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for BAJAJ. Please enter a valid chassis number."
        ];
    }
}

function decodeMahindraTractor($chassisNumber) {
    // Ensure the chassis number is exactly 17 characters and begins with MBN
    if (strlen($chassisNumber) === 17 && strtoupper(substr($chassisNumber, 0, 3)) === 'MBN') {
        $manufacturer = "Mahindra FE";

        // Extract the 10th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[9]);
        $manufacturingMonthCode = strtoupper($chassisNumber[11]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'A' => 2010, 'B' => 2011, 'C' => 2012, 'D' => 2013, 'E' => 2014,
            'F' => 2015, 'G' => 2016, 'H' => 2017, 'J' => 2018, 'K' => 2019,
            'L' => 2020, 'M' => 2021, 'N' => 2022, 'P' => 2023, 'R' => 2024,
            'S' => 2025, 'T' => 2026, 'V' => 2027, 'W' => 2028, 'X' => 2029, 'Y' => 2030, '1' => 2031, '2' => 2032, '3' => 2033, '4' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'K' => 'JANUARY', 'L' => 'FEBRUARY', 'M' => 'MARCH', 'A' => 'APRIL',
                'B' => 'MAY', 'C' => 'JUNE', 'D' => 'JULY', 'E' => 'AUGUST',
                'F' => 'SEPTEMBER', 'G' => 'OCTOBER', 'H' => 'NOVEMBER', 'J' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number for Mahindra Tractor. Please enter a valid chassis number."
        ];
    }
}



function decodeEscortsFE($chassisNumber) {
    // Ensure the chassis number is exactly 12 characters and begins with T05
    if (strlen($chassisNumber) === 12 && strtoupper(substr($chassisNumber, 0, 3)) === 'T05') {
        $manufacturer = "Escorts FE";

        // Extract the 11th and 12th characters for decoding (converted to uppercase)
        $manufacturingYearCode = strtoupper($chassisNumber[11]);
        $manufacturingMonthCode = strtoupper($chassisNumber[10]);

        // Validating and decoding the manufacturing year
        $manufacturingYears = [
            'A' => 2012, 'B' => 2013, 'C' => 2014,
            'D' => 2015, 'E' => 2016, 'F' => 2017, 'G' => 2018, 'H' => 2019,
            'J' => 2020, 'K' => 2021, 'L' => 2022, 'M' => 2023, 'N' => 2024,
            'P' => 2025, 'R' => 2026, 'S' => 2027, 'T' => 2028, 'U' => 2029, 'V' => 2030, 'W' => 2031, 'X' => 2032, 'Y' => 2033, 'Z' => 2034
        ];

        if (isset($manufacturingYears[$manufacturingYearCode])) {
            $manufacturingYear = $manufacturingYears[$manufacturingYearCode];

            // Validating and decoding the manufacturing month
            $manufacturingMonths = [
                'K' => 'JANUARY', 'L' => 'FEBRUARY', 'M' => 'MARCH', 'A' => 'APRIL',
                'B' => 'MAY', 'C' => 'JUNE', 'D' => 'JULY', 'E' => 'AUGUST',
                'F' => 'SEPTEMBER', 'G' => 'OCTOBER', 'H' => 'NOVEMBER', 'J' => 'DECEMBER'
            ];

            if (isset($manufacturingMonths[$manufacturingMonthCode])) {
                $manufacturingMonth = $manufacturingMonths[$manufacturingMonthCode];

                // Store results in the session
                $_SESSION['chassisResult'] = [
                    'manufacturer' => $manufacturer,
                    'manufacturingMonth' => $manufacturingMonth,
                    'manufacturingYear' => $manufacturingYear
                ];
            } else {
                $_SESSION['chassisResult'] = [
                    'error' => "Invalid Chassis Number. Manufacturing month code is not valid."
                ];
            }
        } else {
            $_SESSION['chassisResult'] = [
                'error' => "Invalid Chassis Number. Manufacturing year code is not valid."
            ];
        }
    } else {
        $_SESSION['chassisResult'] = [
            'error' => "Invalid Chassis Number. Please enter a valid chassis number."
        ];
    }
}










// Function to decode chassis for another manufacturer (similar structure as Tata Motors)
function decodeAnotherManufacturer($chassisNumber) {
    // Logic for decoding chassis for another manufacturer
    // ...
}

// Function to validate year code
function isValidYearCode($code) {
    // Logic for validating year code
    // ...
}

// Function to decode year based on code
function decodeYear($code) {
    // Logic for decoding year
    // ...
}

// Function to validate month code
function isValidMonthCode($code) {
    // Logic for validating month code
    // ...
}

// Function to decode month based on code
function decodeMonth($code) {
    // Logic for decoding month
    // ...
}



    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['chassisNumber'])) {
        $chassisNumber = $_POST['chassisNumber'];
        decodeChassis($chassisNumber);
    }
}
// Debugging output
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

header('Location: vin_decoder');
?>
