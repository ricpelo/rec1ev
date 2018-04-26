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
            'instante' => 'Instante',
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

    public static function siguiente(): DateTime
    {
        $ultimo = static::find()->max('instante');

        if ($ultimo === null) {
            $ultimo = (new DateTime('now'))
                ->setTimeZone(new DateTimeZone(Yii::$app->formatter->timeZone))
                ->add(new DateInterval('P1D'))
                ->setTime(10, 0, 0)
                ->setTimeZone(new DateTimeZone('UTC'));
        } else {
            $local = (new DateTime($ultimo))
                ->setTimeZone(new DateTimeZone(Yii::$app->formatter->timeZone))
                ->format('H:i');
            if ($local == '20:45') {
                // sumar un día y ponerlo a las 10:00
                $ultimo = (new DateTime($ultimo))
                    ->setTimeZone(new DateTimeZone(Yii::$app->formatter->timeZone))
                    ->add(new DateInterval('P1D'))
                    ->setTime(10, 0, 0)
                    ->setTimeZone(new DateTimeZone('UTC'));
            } else {
                // sumar 15 minutos
                $ultimo = (new DateTime($ultimo))
                    ->add(new DateInterval('PT15M'));
            }
        }

        return $ultimo;
    }
}
