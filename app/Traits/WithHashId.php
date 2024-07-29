<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;

trait WithHashId
{
    public $hashIdOptions = [];

    public function getHashIdOptions() : array
    {
        return [
            'length' => 15,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyz0123456789'
        ];
    }

    public function scopeHashid(Builder $builder, string $hashid)
    {
        return $builder->where('hashid', $hashid);
    }

    public static function getId(string $hashid)
    {
        return static::hashid($hashid)->first()?->id;
    }

    public function getRouteKeyName()
    {
        return 'hashid';
    }

    protected static function bootWithHashId(): void
    {
        static::created(function (Model $model) {
            $model->generateHashIdOnCreatedEvent();
            $model->saveQuietly();
        });
    }

    protected function generateHashIdOnCreatedEvent(): void
    {
        $this->hashIdOptions = $this->getHashIdOptions();

        $this->addHashId();
    }

    protected function addHashId(): void
    {
        $hashId = $this->generateHashId();

        $this->hashid = $hashId;
    }

    protected function generateHashId(): string
    {
        $hashids = new Hashids(
            '',
            $this->hashIdOptions['length'],
            $this->hashIdOptions['alphabet']);

            return $hashids->encode($this->id);
    }
}
