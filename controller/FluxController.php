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

            $idParentRole = null;

            try {
                // send flux to next class of users
                $idParentRole = $this->userRepo->getRoleParentId($this->user->getRole());
            } catch (Exception $e) {
                // pass
            }

            if ($idParentRole === null) {
                // this user role has no parent, keep flux to current user role
                $idParentRole = $this->userRepo->getRoleId($this->user->getRole());
            }

            $flux = new Flux($request['name'], $request['description'], $this->user->getId(), $idParentRole);

            $fluxId = $this->fluxRepo->insert($flux);

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

            $fluxData = $this->fluxRepo->get($where);

            foreach ($fluxData as $f) {

                $result[] = $this->fluxToArray($f);
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

                $result[] = $this->fluxToArray($f);
            }

        } catch (Exception $e) {
            // pass
        }

        return $this->response($result);
    }

    public function getOneAction($fluxId)
    {
        try {

            // TODO implement validation to check if user has the rights to see this flux

            $flux = $this->fluxRepo->get(array(
                'flux.id' => $fluxId
            ))[0];

            $flux = $this->fluxToArray($flux);
            $flux['documents'] = array();

            try {

                $documents = $this->docRepo->getDocumentsByFlux($flux['id']);

                foreach ($documents as $doc) {
                    $flux['documents'][] = $doc->toArray();
                }

            } catch (Exception $e) {
                // no documents for this flux
            }

            return $this->response($flux);

        } catch (Exception $e) {

            return $this->errorResponse('Flux not found');
        }
    }

    public function getDocumentsAction($fluxId)
    {
        $result = [];

        try {

            $documents = $this->docRepo->getDocumentsByFlux($fluxId);

            foreach ($documents as $doc) {
                $result[] = $doc->toArray();
            }


        } catch (Exception $e) {
            // no documents for this flux
        }

        return $this->response($result);

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

    public function acceptAction($fluxId, $type = 'accept')
    {
        try {

            $flux = $this->fluxRepo->get(array(
                'flux.id' => $fluxId
            ))[0];

            $userRole = $this->userRepo->getRole($this->user->getRole());

            if ($userRole['id'] != $flux->getIdRoleCurrent()) {
                throw new Exception("You don't have rights to update this flux");
            }

            $id_parent = $userRole['id_parent'];

            if ($type != 'accept') {

                $status = FluxStatus::Rejected;

            } else {
                $status = FluxStatus::Pending;

                if ($userRole['id_parent'] === null) {

                    $status = FluxStatus::Approved;
                    $id_parent = $userRole['id'];
                }
            }

            $idStatus = $this->fluxRepo->getFluxStatusId($status);

            $this->fluxRepo->update(array(
                'id' => $flux->getId()
            ), array(
                'id_status' => $idStatus,
                'id_role_current' => $id_parent
            ));

            return $this->response(array(
                'status' => 'Success'
            ));

        } catch (Exception $e) {

            return $this->errorResponse('Accept failed');
        }
    }

    public function rejectAction($fluxId)
    {
        return $this->acceptAction($fluxId, 'reject');
    }

    public function deleteAction($fluxId)
    {
        try {

            $this->fluxRepo->delete(array(
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

    protected function fluxToArray($f)
    {
        $flux = $f->toArray();

        $userInit = $this->userRepo->getUserById($f->getIdUserInit());
        $role = $this->userRepo->getRoleById($f->getIdRoleCurrent());

        $flux['user_init'] = $userInit->getUsername();
        $flux['role_current'] = $role['name'];

        return $flux;
    }
}