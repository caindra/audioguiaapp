<?php

namespace App\Factory;

use App\Entity\Audioguide;
use App\Repository\AudioguideRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Audioguide>
 *
 * @method        Audioguide|Proxy                     create(array|callable $attributes = [])
 * @method static Audioguide|Proxy                     createOne(array $attributes = [])
 * @method static Audioguide|Proxy                     find(object|array|mixed $criteria)
 * @method static Audioguide|Proxy                     findOrCreate(array $attributes)
 * @method static Audioguide|Proxy                     first(string $sortedField = 'id')
 * @method static Audioguide|Proxy                     last(string $sortedField = 'id')
 * @method static Audioguide|Proxy                     random(array $attributes = [])
 * @method static Audioguide|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AudioguideRepository|RepositoryProxy repository()
 * @method static Audioguide[]|Proxy[]                 all()
 * @method static Audioguide[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Audioguide[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Audioguide[]|Proxy[]                 findBy(array $attributes)
 * @method static Audioguide[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Audioguide[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AudioguideFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'audioEn' => self::faker()->url(),
            'audioEs' => self::faker()->url(),
            'image' => self::faker()->image(),
            'nameEn' => self::faker()->words(3),
            'nameEs' => self::faker()->words(3),
            'textEn' => self::faker()->text(),
            'textEs' => self::faker()->text(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Audioguide $audioguide): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Audioguide::class;
    }
}
