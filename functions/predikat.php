<?php

function predikatHuruf(Int $kkm, Int $nilai)
{
    if ($nilai < $kkm)
        return 'D';

    if ($nilai >= $kkm && $nilai < $kkm + 10)
        return 'C';

    if ($nilai + 10 >= $kkm && $nilai < $kkm + 20)
        return 'B';

    if ($nilai + 20 >= $kkm && $nilai < $kkm + 30)
        return 'A';

    return false;
}

function predikatKata(String $huruf)
{
    if ($huruf === 'D')
        return 'Kurang';

    if ($huruf === 'C')
        return 'Cukup';

    if ($huruf === 'B')
        return 'Baik';

    if ($huruf === 'A')
        return 'Sangat Baik';

    return false;
}
