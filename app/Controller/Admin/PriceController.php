<?php

namespace App\Controller\Admin;

use App\Model\Price;
use App\Support\View;
use App\Support\RouteParser;
use App\Support\BaseController;
use App\Validators\Validator as v;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;


class PriceController extends BaseController
{
	/**
	 * get all prices resources
	 *
	 * @return Response
	 */
	public function get(): Response
	{

		//database call 
		$data = Price::all();
		//refactor data to format and merge json
		foreach ($data as $price) {
			$from = $price->p_id != 5 ? 'à partir de ' . $price->p_price : $price->p_price;
			$dataArray = [
				'id' => $price->p_id,
				'title' => $price->p_title,
				'price' => $from,
				'devise' => $price->p_devise,
				'description' => $price->p_description,
				'btn' => $price->p_btn
			];
			$content = (array) json_decode($price->p_content);
			$priceData[] = array_merge($dataArray, $content);
		}

		return View::render('admin@pages@admin_prices', ['data' => $priceData]);
	}


	/**
	 * show form to edit price resource
	 *
	 * @param Response $response
	 * @param integer $id
	 * @return Response
	 */
	public function edit(Response $response, int $id): Response
	{
		$data = Price::get($id);
		if ($data) {
			$dataArray = [
				'id' => $data->p_id,
				'title' => $data->p_title,
				'price' => $data->p_price,
				'devise' => $data->p_devise,
				'description' => $data->p_description,
				'content' => $data->p_content,
				'btn' => $data->p_btn
			];
			return View::render('admin@pages@admin_price_edit', ['data' => $dataArray]);
		}
		return $response->withStatus(404);
	}

	/**
	 * Update price resource
	 *
	 * @param Response $response
	 * @param integer $id
	 * @return Response
	 */
	public function update(ServerRequestInterface $request, Response $response, int $id): Response
	{

		$request = $request->getParsedBody();

		$validate = $this->validate($request);

		if (!is_null($validate)) {
			//return errors in session
			$this->session->set('errors',$validate);
			$redirect = RouteParser::urlFor('admin.prices.edit',['id' => $id]);
			return $response->withHeader('Location', $redirect)->withStatus(302);
		} 

		// do stuff
		$succed = Price::update($request, $id);
		if (!$succed) {
			return $response->withStatus(500, 'Un proble est survenu lors de la mise à jour de la ressource');
		}
		$redirect = RouteParser::urlFor('admin.prices');
		return $response->withHeader('Location', $redirect)->withStatus(302);
	}

	public function showCreateForm(): Response
	{
		return View::render('admin@pages@admin_price_create');
	}

	public function create(ServerRequestInterface $request, Response $response): Response
	{
		$request = $request->getParsedBody();

		$validate = $this->validate($request);

		if (!is_null($validate)) {
			//return errors in session
			$this->session->set('errors',$validate);
			$redirect = RouteParser::urlFor('admin.prices.create');
			return $response->withHeader('Location', $redirect)->withStatus(302);
		} 
		$succed = Price::create($request);
		if (!$succed) {
			return $response->withStatus(500, 'Un probleme est survenu lors de la creation de la ressource ');
		}
		$redirect = RouteParser::urlFor('admin.prices');
		return $response->withHeader('Location', $redirect)->withStatus(302);
	}

	public function validate(array $request)
	{

		$validator = v::validate($request)->check('p_title', 'string|required|min:5|max:255')
			->check('p_description', 'required|string|min:5')
			->check('p_price', 'num')
			->check('p_devise', 'string|nullable')
			->check('p_content', 'string|json|nullable')
			->check('p_btn', 'string|nullable');
		return $validator->getErrors();
	}

	public function delete(Response $response,$id) {
		$delete = Price::delete($id);
		if($delete) {
			$redirect = RouteParser::urlFor('admin.prices');
			return $response->withHeader('Location', $redirect)->withStatus(302);
		}
		return $response->withStatus(500, 'Un probleme est survenu lors de la suppression de la ressource');
	}
}
