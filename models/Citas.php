<?php

namespace app\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;

/**
 * This is the model class for table "citas".
 *
 * @property int $id
 * @property string $instante
 * @property int $usuario_id
 *
 * @property Usuarios $usuario
 */
class Citas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'citas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['instante', 'usuario_id'], 'required'],
            [['instante'], 'safe'],
            [['usuario_id'], 'default', 'value' => null],
            [['usuario_id'], 'integer'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instante' => 'Fecha y hora',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('citas');
    }

    //   select instante::date
    //     from citas
    // group by instante::date
    //   having count(*) < 44
    // order by instante::date
    //    limit 1;

    //   select *
    //    from generate_series('2018-04-27 08:00'::timestamp, '2018-04-27 18:45'::timestamp, '15 minutes') t(f)
    //   where f not in (select instante
    //                     from citas
    //                    where instante::date = '2018-04-27');

    public static function siguiente(): DateTime
    {
        $ultimo = static::find()->max('instante') ?? 'now';
        $zona = new DateTimeZone(Yii::$app->formatter->timeZone);

        $local = (new DateTime($ultimo))->setTimeZone($zona)->format('H:i');

        if ($local == '20:45' || $ultimo == 'now') {
            // sumar un día y ponerlo a las 10:00
            $siguiente = (new DateTime($ultimo))
                    ->setTimeZone($zona)
                    ->add(new DateInterval('P1D'))
                    ->setTime(10, 0, 0)
                    ->setTimeZone(new DateTimeZone('UTC'));
        } else {
            // sumar 15 minutos
            $siguiente = (new DateTime($ultimo))->add(new DateInterval('PT15M'));
        }

        return $siguiente;
    }

    public static function anulables()
    {
        return static::find()
            ->where('instante > localtimestamp')
            ->andWhere([
                'usuario_id' => Yii::$app->user->id,
            ])
            ->all();
    }
}
