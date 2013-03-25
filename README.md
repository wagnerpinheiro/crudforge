# CRUDForge Project: Make SOLID Data


Plataforma para gestão de dados de forma colaborativa e extensível de alto nível:

1. Compartilhamento de Schemas [CRUD](http://en.wikipedia.org/wiki/Create,_read,_update_and_delete);
2. Compartilhamento de dados;
3. Sistema de gestão para PME (pequenas e médias empresas), altamente customizado e de acordo com as necessidades;

## Contexto

### Visão

* subir o nível de abstração para o desenvolvimento de aplicativos online e com funcionalidades prontas de ERP; 
* usuário final: 
 1. qualquer pessoa que queira estruturar e compartilhar dados;
 2. gestor de PME que conhece o seu negócio, e que por restrições financeiras ou operacionais não tenha interesse em um ERP, mas quer ir além do que gerenciar o seu negócio apenas com planilhas, alguém que queira gerar um diferencial competitivo, disponibilizando dados para os seus clientes e aumentando a produtividade em um ambiente multi-usuário descentralizado e controlado;
* o CRUDForge não tem a intenção de ser um ERP, pois o usuário final em seu contexto comercial, é o gestor que entende do seu negócio e nesse caso não faz sentido provermos uma solução rígida que ele deve seguir para obter resultados, ao invés disso queremos prover uma plataforma para que ele desenvolva ou seus conceitos livremente, sem ficar atado ao que já existe. Não queremos moldar o usuário, e sim moldar uma infraestrutura sólida de apoio para os seus negócios.

### Conceitos
* KISS, DRY, SOLID (mantenha simples, não se repita, manter e estender de forma simples);
* implementar CRUD e Relatórios para que o usuário final realize o desenvolvimento RAD e gere aplicações RIA;

### TCC

O CRUDForge é a idealização de um projeto para o TCC do curso de Engenharia da Computação.
Considerações:
* foco na arquitetura da plataforma:
 * especificação e integração dos serviços, frameworks e bibliotecas;
 * arquitetura SOA;
* apoiado sobre a engenharia de software:
 * gestão de projeto;
 * desenvolvimento ágil;
 * modelagem UML;
 * testes;

O CRUDForge não é:
* Um aplicativo;
* Um plugin;
* Uma biblioteca;
* Um framework;
* Um ERP;

CRUDForge é uma [plataforma](http://webinsider.uol.com.br/2012/03/01/plataforma-de-software-voce-ainda-vai-usar-uma/) de implantação simples via [Virtual Appliance](http://en.wikipedia.org/wiki/Virtual_appliance). Sendo este virtual appliance um protótipo que será entregue ao final do TCC, junto com as especificações e o desenvolvimento dos conceitos por trás da plataforma.
 
### Casos de uso
1. TO-DO list: Imagine que você queira montar uma lista de tarefas e compartilhar com a sua família, para isso você define o CRUD através de uma interface amigável e cria um relatório para que as pessoas dentro do seu ACL possam ver essas tarefas. Você pode criar um campo chamado categoria, onde dependendo do seu valor os usuários dentro do seu ACL terão ou não a visibilidade daquela tarefa;
2. Compartilhamento de inventario: Pode ser montado um CRUD para você lançar as informações que quiser por exemplo da sua coleção de DVD e a partir dele cria-se um relatório através de um template onde será publicado um pagina publica, onde qualquer amigo seu possa ver quais os DVDs você possui;
3. Contas a pagar e receber: CRUD para implementar um controle de contas a pagar e receber básico utilizado em qualquer empresa. O usuário pode estender esse CRUD adicionando campos que fazem sentido para a empresa dele ou removendo outros campos;
4. Controle básico de estoque: CRUD para o lançamento de baixa e controle de estoque;
5. Gestão simples de varejo: Tendo os módulos 3 e 4 disponíveis, o usuário pode agregar esses schemas (dentre outros) na sua conta e com isso montar um pequeno sistema de gestão para a sua loja de varejo;

