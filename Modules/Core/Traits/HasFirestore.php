<?php
/**
 * Created by PhpStorm.
 * User: BaRaa
 * Date: 9/6/2021
 * Time: 3:18 م
 */

namespace Modules\Core\Traits;


use Modules\Core\Repositories\FirestoreRepository;

trait HasFirestore
{

    public $firestoreRepository;

    /**
     * HasFirestore constructor.
     * @param FirestoreRepository $firestoreRepository
     */
    public function __construct(FirestoreRepository $firestoreRepository)
    {
        $this->firestoreRepository = $firestoreRepository;
//        parent::__construct();
    }
}
