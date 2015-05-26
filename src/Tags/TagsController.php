<?php
namespace Anax\Tags;

/**
 * A controller for users and admin related events.
 *
 */
class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * Initialize the controller
     *
     * @return void
     */
    public function initialize()
    {
        $this->tags = new \Anax\Tags\Tag();
        $this->tags->setDI($this->di);
    }



    /**
     * Initialize the controller
     *
     * @return void
     */
    public function amountOfTag()
    {
        $all = $this->tags->findAll();
        $allRelated = $this->dispatcher->forward([
            'controller' => 'q2t',
            'action' => 'getAll',
        ]);

        foreach ($all as $tag) {
            $amount = 0;
            foreach ($allRelated as $val) {
                if ($tag->id == $val->tag_id) {
                    $amount++;
                }

                $this->tags->save([
                    'id' => $tag->id,
                    'tag_description' => $tag->tag_description,
                    'amount' => $amount,
                ]);

            }
        }
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function indexAction($id, $tags = [])
    {
        $ids_for_tag;
        foreach ($tags as $tag) {
            $this->initialize();
            $tag = mb_strtolower($tag, 'UTF-8');
            $tag = str_replace('å', 'a', $tag);
            $tag = str_replace('ä', 'a', $tag);
            $tag = str_replace('ö', 'o', $tag);
            $tag = str_replace('.', 'dot', $tag);
            $tag = str_replace(' ', '-', $tag);
            $tag = str_replace('$', 'dollar', $tag);
            $tag = str_replace('€', 'euro', $tag);
            $tag = str_replace('!', 'exclaim', $tag);
            $tag = preg_replace("/[^a-z0-9-]/", '-', $tag);
            $tag = preg_replace("/-{2,}/", '-', $tag);
            $tag = trim($tag, '-');
            $tag = ucfirst($tag);

            $existingTag = $this->tags->getIdWithTag($tag);
            if (isset($existingTag) && isset($existingTag->id)) {
                //Updates existing
                $this->tags->save([
                    'id'    => $existingTag->id,
                    'tag_description' => $tag,
                    'amount' => $existingTag->amount + 1,
                ]);
                $ids_for_tag[] = $existingTag->id;
            } else {
                //Creates new
                $this->tags->save([
                    'tag_description' => $tag,
                    //'amount' => 1,
                ]);

                $tagid = $this->tags->getlastInsertId();
                $ids_for_tag[] = $tagid;
            }
        }
        $this->di->dispatcher->forward([
          'controller' => 'q2t',
          'action'     => '',
          'params'     => [$id, $ids_for_tag],
        ]);



        $url = $this->url->create('questions/id/' . $id);
        $this->response->redirect($url);
    }



    /**
     * Add new question.
     *
     * @param array $values of question to add
     *
     * @return void
     */
    public function updateAction($id, $tags = [])
    {
        $ids_for_tag;
        $this->initialize();
        foreach ($tags as $tag) {

            $tag = mb_strtolower($tag, 'UTF-8');
            $tag = str_replace('å', 'a', $tag);
            $tag = str_replace('ä', 'a', $tag);
            $tag = str_replace('ö', 'o', $tag);
            $tag = str_replace('.', 'dot', $tag);
            $tag = str_replace(' ', '-', $tag);
            $tag = str_replace('$', 'dollar', $tag);
            $tag = str_replace('€', 'euro', $tag);
            $tag = str_replace('!', 'exclaim', $tag);
            $tag = preg_replace("/[^a-z0-9-]/", '-', $tag);
            $tag = preg_replace("/-{2,}/", '-', $tag);
            $tag = trim($tag, '-');
            $tag = ucfirst($tag);

            $existingTag = $this->tags->getIdWithTag($tag);
            if (isset($existingTag) && isset($existingTag->id)) {
                $this->tags->save([
                    'id'    => $existingTag->id,
                    'tag_description' => $tag,
                    //'amount' => $existingTag->amount + 1,
                ]);
                $ids_for_tag[] = $existingTag->id;
            } else {
                $this->tags->save([
                    'tag_description' => $tag,
                    //'amount' => 1,
                ]);

                $tagid = $this->tags->getlastInsertId();
                dump($tagid);
                $ids_for_tag[] = $tagid;
            }
        }

        $this->di->dispatcher->forward([
          'controller' => 'q2t',
          'action'     => 'update',
          'params'     => [$id, $ids_for_tag],
        ]);

        //$this->amountOfTag();
    }



    /**
     * List all tags.
     *
     * @return void
     */
    public function listAction()
    {
        $this->amountOfTag();
        $form = new \Mos\HTMLForm\CForm(['action' => '?', 'method' => 'get'], [
            'search' => [
                'type'        => 'search-widget',
                'placeholder' => 'Search for tags',
                'label'       => 'Search',
                'callback'  => function ($form) {
                    $form->saveInSession = true;
                    return true;
                }
            ],
        ]);

        $search = $this->request->getGet('search');
        $this->initialize();

        $all = $this->tags->findAllSearch($search);
        $allRelated = $this->dispatcher->forward([
            'controller' => 'q2t',
            'action' => 'getAll',
        ]);

        $this->theme->setTitle("List all tags");
        $this->views->add('tags/list', [
            'search' => $form->getHTML(),
            'tags' => $all,
            'related' => $allRelated,
            'title' => "View all Tags",
            'searchword' => $search,
        ]);
    }


    /**
     * List all tags on the front page.
     */
    public function frontpageAction()
    {
        $all = $this->tags->findAllLimit(25);
        $allRelated = $this->dispatcher->forward([
            'controller' => 'q2t',
            'action' => 'getAll',
        ]);

        $this->views->add('tags/front', [
            'tags' => $all,
            'title' => "Tags",
        ], 'flash');
    }

















}
