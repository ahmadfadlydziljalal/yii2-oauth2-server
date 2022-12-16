<?php

namespace app\models\active_query;

/**
 * This is the ActiveQuery class for [[\app\models\OauthClients]].
 *
 * @see \app\models\OauthClients
 */
class OauthClientsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\OauthClients[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\OauthClients|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
