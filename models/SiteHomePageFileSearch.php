<?php
namespace app\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SiteHomePageFile;
class SiteHomePageFileSearch extends SiteHomePageFile
{
	public $STR_AUTHOR_ACRONYM;
	public $STR_NAME_AUTHOR;
	public $STR_FILE_CODE;
	public $INT_FK_SITE_ORIENTATION_FILE_ID;
    public function rules()
    {
        return [
            [['INT_PK_ID_SITE_HOMEPAGE_FILE', 'INT_FK_SITE_FILE_ID', 'INT_FK_SITE_AUTHOR_ID', 'INT_FK_SITE_ORIENTATION_FILE_ID'], 'integer'],
        	[['STR_AUTHOR_ACRONYM', 'STR_NAME_AUTHOR', 'STR_FILE_CODE', 'TST_CREATION_DATE'], 'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = SiteHomePageFile::find()->joinWith(['siteAuthor','siteFile']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort'=> ['defaultOrder' => [
        		'TST_CREATION_DATE' => DESC_ASC,	
        		'siteAuthor.STR_AUTHOR_ACRONYM'=>SORT_ASC, 
        		'siteFile.STR_FILE_CODE'=>SORT_ASC
        		]
        	]
        ]);
        $dataProvider->sort->attributes['siteAuthor.STR_AUTHOR_ACRONYM'] = [
        	'asc' => ['STR_AUTHOR_ACRONYM' => SORT_ASC],
        	'desc' => ['STR_AUTHOR_ACRONYM' => SORT_DESC]	
        ];
        $dataProvider->sort->attributes['siteAuthor.STR_NAME_AUTHOR'] = [
        	'asc' => ['STR_NAME_AUTHOR' => SORT_ASC],
        	'desc' => ['STR_NAME_AUTHOR' => SORT_DESC]	
        ];
        $dataProvider->sort->attributes['siteFile.STR_FILE_CODE'] = [
        	'asc' => ['STR_FILE_CODE' => SORT_ASC],
        	'desc' => ['STR_FILE_CODE' => SORT_DESC]	
        ];
        $dataProvider->sort->attributes['siteFile.INT_FK_SITE_ORIENTATION_FILE_ID'] = [
        	'asc' => ['INT_FK_SITE_ORIENTATION_FILE_ID' => SORT_ASC],
        	'desc' => ['INT_FK_SITE_ORIENTATION_FILE_ID' => SORT_DESC]	
        ];
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'INT_PK_ID_SITE_HOMEPAGE_FILE' => $this->INT_PK_ID_SITE_HOMEPAGE_FILE,
            'INT_FK_SITE_FILE_ID' => $this->INT_FK_SITE_FILE_ID,
            'INT_FK_SITE_AUTHOR_ID' => $this->INT_FK_SITE_AUTHOR_ID,
        	'STR_AUTHOR_ACRONYM' => $this->STR_AUTHOR_ACRONYM,
        	'STR_NAME_AUTHOR' => $this->STR_NAME_AUTHOR,
        	'STR_FILE_CODE' => $this->STR_FILE_CODE,
        	'INT_FK_SITE_ORIENTATION_FILE_ID' => $this->INT_FK_SITE_ORIENTATION_FILE_ID,
        	'TST_CREATION_DATE' => $this->TST_CREATION_DATE,
        ]);
        $query->andFilterWhere(['like', 'INT_PK_ID_SITE_HOMEPAGE_FILE', $this->INT_PK_ID_SITE_HOMEPAGE_FILE])
	        ->andFilterWhere(['like', 'INT_FK_SITE_FILE_ID', $this->INT_FK_SITE_FILE_ID])
	        ->andFilterWhere(['like', 'INT_FK_SITE_AUTHOR_ID', $this->INT_FK_SITE_AUTHOR_ID])
	        ->andFilterWhere(['like', ErpAuthor::tableName().'S.TR_AUTHOR_ACRONYM', $this->STR_AUTHOR_ACRONYM])
	        ->andFilterWhere(['like', ErpAuthor::tableName().'.STR_NAME_AUTHOR', $this->STR_NAME_AUTHOR])
	        ->andFilterWhere(['like', SiteFile::tableName().'.STR_FILE_CODE', $this->STR_FILE_CODE])
	        ->andFilterWhere(['like', SiteFile::tableName().'.INT_FK_SITE_ORIENTATION_FILE_ID', $this->INT_FK_SITE_ORIENTATION_FILE_ID])
	        ->andFilterWhere(['like', '.TST_CREATION_DATE', $this->TST_CREATION_DATE]);
        return $dataProvider;
    }
    public function getPictureByIdFile($intIdHomePageIdFile)
    {
    	return SiteHomePageFile::find()->where(['INT_FK_SITE_FILE_ID' => $intIdHomePageIdFile])->one();
    }
}