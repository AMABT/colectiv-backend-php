<?php

include_once REPOSITORY_FOLDER . 'FluxRepository.php';
include_once REPOSITORY_FOLDER . 'UserRepository.php';
include_once REPOSITORY_FOLDER . 'DocumentRepository.php';

class FluxController extends BaseController
{

    protected $fluxRepo;
    protected $userRepo;
    protected $docRepo;

    public function __construct()
    {
        $this->fluxRepo = new FluxRepository();
        $this->userRepo = new UserRepository();
        $this->docRepo = new DocumentRepository();
    }

    public function createAction()
    {
        try {

            $request = $this->request();

            LogService::info($request);

            try {
                // send flux to next class of users
                $idParentRole = $this->userRepo->getRoleParentId($this->user->getRole());
            } catch (Exception $e) {
                // this user role has no parent, keep flux to current user role
                $idParentRole = $this->userRepo->getRoleId($this->user->getRole());
            }

            $flux = new Flux($request['name'], $request['description'], $this->user->getId(), $idParentRole);

            $fluxId = $this->fluxRepo->insert($flux);

            LogService::info($fluxId);

            if (!empty($request['documents'])) {

                foreach ($request['documents'] as $documentId) {

                    $document = $this->docRepo->get(array(
                        'id' => $documentId
                    ))[0];

                    if ($document->getIdUser() != $this->user->getId()) {
                        throw new Exception("You don't have access to current document ");
                    }

                    $this->fluxRepo->addDocumentToFlux($fluxId, $documentId);
                }
            }

            return $this->response(array(
                'status' => 'success'
            ));

        } catch (Exception $e) {
            return $this->errorResponse('Insert failed');
        }
    }

    public function addDocumentAction($fluxId, $documentId)
    {
        try {

            $this->fluxRepo->addDocumentToFlux($fluxId, $documentId);

            return $this->response(array(
                'status' => 'success'
            ));

        } catch (Exception $e) {
            return $this->errorResponse('Insert failed');
        }
    }

    public function getAllAction($status = null)
    {
        $result = array();

        try {

            $where = array('id_user_init' => $this->user->getId());

            if ($status !== null) {

                // If status is not null, return all flux where
                $statusId = $this->fluxRepo->getFluxStatusId($status);

                $where['id_status'] = $statusId;
            }

            $flux = $this->fluxRepo->get($where);

            foreach ($flux as $f) {
                $result[] = $f->toArray();
            }

        } catch (Exception $e) {
            // pass
        }

        return $this->response($result);
    }

    public function getPending()
    {
        $result = array();

        try {

            $userRoleId = $this->userRepo->getRoleId($this->user->getRole());

            $flux = $this->fluxRepo->get(array(
                'id_role_current' => $userRoleId
            ));

            foreach ($flux as $f) {
                $result[] = $f->toArray();
            }

        } catch (Exception $e) {
            // pass
        }

        return $this->response($result);
    }

    public function getOneAction($fluxId)
    {
        try {

            $flux = $this->fluxRepo->get(array(
                'id' => $fluxId
            ))[0];

            return $this->response($flux->toArray());

        } catch (Exception $e) {

            return $this->errorResponse('Flux not found');
        }
    }

    public function updateAction($fluxId)
    {
        try {

            $request = $this->request();

            $flux = $this->fluxRepo->get(array(
                'id' => $fluxId
            ))[0];

            foreach ($request as $key => $val) {

                $method = 'set' . $key;

                $flux->$method($val);
            }

            $this->fluxRepo->update(array(
                'id' => $flux->getId()
            ), $flux);

            return $this->response(array(
                'status' => 'Success'
            ));

        } catch (Exception $e) {

            return $this->errorResponse('Update failed');
        }
    }

    public function deleteAction($fluxId)
    {
        try {

            $this->userRepo->delete(array(
                'id' => $fluxId,
                'id_user_init' => $this->user->getId()
            ));

            return $this->response(array(
                'status' => 'Success'
            ));

        } catch (Exception $e) {

            return $this->errorResponse('Flux not found or you are not the creator of this flux');
        }
    }
}